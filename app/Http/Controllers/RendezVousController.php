<?php

namespace App\Http\Controllers;

use App\Mail\RendezVousConfirmedMail;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\TransactionPoint;
use App\Repositories\Contracts\RendezVousRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class RendezVousController extends Controller
{
    public function __construct(private readonly RendezVousRepositoryInterface $rendezVousRepository)
    {

    }

    private function getMedecinAppointmentCost(Medecin $medecin): int
    {
        if (Schema::hasColumn('medecins', 'appointment_points_cost')) {
            return max(1, (int) ($medecin->appointment_points_cost ?: Medecin::DEFAULT_APPOINTMENT_POINTS_COST));
        }

        return RendezVous::DEFAULT_POINTS_COST;
    }

    private function awardMedecinPointsIfEligible($rendezVous): void
    {
        if (
            ! Schema::hasColumn('medecins', 'points')
            || ! Schema::hasColumn('rendez_vous', 'medecin_points_awarded')
        ) {
            return;
        }

        if (
            ! $rendezVous->medecin_id
            || ! in_array($rendezVous->statut, ['confirme', 'confirmé'], true)
            || $rendezVous->medecin_points_awarded
        ) {
            return;
        }

        $medecin = Medecin::find($rendezVous->medecin_id);

        if (! $medecin) {
            return;
        }

        $pointsToAward = Schema::hasColumn('rendez_vous', 'points_cost')
            ? (int) ($rendezVous->points_cost ?: RendezVous::DEFAULT_POINTS_COST)
            : RendezVous::DEFAULT_POINTS_COST;

        $medecin->increment('points', max(1, $pointsToAward));
        $rendezVous->update(['medecin_points_awarded' => true]);
    }

    private function sendConfirmationEmailIfEligible($rendezVous, ?string $previousStatus = null): void
    {
        if (! in_array($rendezVous->statut, ['confirme', 'confirmé'], true)) {
            return;
        }

        if (in_array($previousStatus, ['confirme', 'confirmé'], true)) {
            return;
        }

        $rendezVous->loadMissing(['patient.user', 'medecin.user']);

        $patientEmail = $rendezVous->patient?->user?->email;

        if (! $patientEmail) {
            return;
        }

        $lieu = $rendezVous->medecin?->user?->ville
            ? 'Cabinet du médecin - ' . $rendezVous->medecin->user->ville
            : 'Lieu à confirmer par le médecin';

        Mail::to($patientEmail)->send(new RendezVousConfirmedMail($rendezVous, $lieu));
    }

    private function chargePatientPointsIfEligible($rendezVous): ?string
    {
        if (
            ! Schema::hasColumn('rendez_vous', 'points_cost')
            || ! Schema::hasColumn('rendez_vous', 'patient_points_spent')
        ) {
            return null;
        }

        if (
            ! $rendezVous->patient_id
            || ! in_array($rendezVous->statut, ['confirme', 'confirmé'], true)
            || $rendezVous->patient_points_spent
        ) {
            return null;
        }

        $cost = (int) ($rendezVous->points_cost ?: RendezVous::DEFAULT_POINTS_COST);

        if ($cost <= 0) {
            return null;
        }

        return DB::transaction(function () use ($rendezVous, $cost) {
            $patient = Patient::query()->lockForUpdate()->find($rendezVous->patient_id);

            if (! $patient) {
                return 'Le patient lie a ce rendez-vous est introuvable.';
            }

            if ((int) $patient->points < $cost) {
                return 'Le patient n a pas assez de points pour confirmer ce rendez-vous.';
            }

            $patient->decrement('points', $cost);

            TransactionPoint::create([
                'patient_id' => $patient->id,
                'montant' => -$cost,
                'type' => 'depense',
                'description' => 'Depense de points pour le rendez-vous du ' . $rendezVous->date . ' a ' . substr((string) $rendezVous->heure, 0, 5),
            ]);

            $rendezVous->update(['patient_points_spent' => true]);

            return null;
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('patient')) {
            if (! $user->patient) {
                return redirect()->route('dashboard')
                    ->with('success', 'Votre profil patient n est pas encore complet.');
            }
        }
        elseif ($user->hasRole('medecin')) {
            if (! $user->medecin) {
                return redirect()->route('dashboard')
                    ->with('success', 'Votre profil medecin n est pas encore complet.');
            }
        }

        $rendezVous = $this->rendezVousRepository->getForUser($user);

        return view('rendezvous.index', compact('rendezVous'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_unless(auth()->user()->hasRole('patient'), 403);

        $medecins = Medecin::with('user')
            ->where('is_validated', true)
            ->get();
        $doctorCosts = $medecins->mapWithKeys(fn (Medecin $medecin) => [
            $medecin->id => $this->getMedecinAppointmentCost($medecin),
        ]);
        $selectedMedecin = $medecins->firstWhere('id', (int) request('medecin_id'));
        $appointmentCost = $selectedMedecin
            ? $this->getMedecinAppointmentCost($selectedMedecin)
            : RendezVous::DEFAULT_POINTS_COST;

        return view('rendezvous.create', compact('medecins', 'appointmentCost', 'doctorCosts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        abort_unless($user->hasRole('patient') && $user->patient, 403);

        $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date' => 'required|date',
            'heure' => 'required'
        ]);

        $medecin = Medecin::findOrFail($request->medecin_id);

        $payload = [
            'patient_id' => $user->patient->id,
            'medecin_id' => $medecin->id,
            'date' => $request->date,
            'heure' => $request->heure,
            'statut' => 'en_attente',
        ];

        if (Schema::hasColumn('rendez_vous', 'points_cost')) {
            $payload['points_cost'] = $this->getMedecinAppointmentCost($medecin);
        }

        $this->rendezVousRepository->create($payload);

        return redirect()->route('rendezvous.index')->with('success', 'Rendez-vous demande avec succes.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rendezVous = $this->rendezVousRepository->findById($id);
        $user = auth()->user();

        abort_unless(
            $user->hasRole('admin')
            || ($user->hasRole('patient') && $user->patient && $rendezVous->patient_id === $user->patient->id)
            || ($user->hasRole('medecin') && $user->medecin && $rendezVous->medecin_id === $user->medecin->id),
            403
        );

        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->get();
        $doctorCosts = $medecins->mapWithKeys(fn (Medecin $medecin) => [
            $medecin->id => $this->getMedecinAppointmentCost($medecin),
        ]);

        return view('rendezvous.edit', compact('rendezVous', 'patients', 'medecins', 'doctorCosts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rendezVous = $this->rendezVousRepository->findById($id);
        $user = auth()->user();

        abort_unless(
            $user->hasRole('admin')
            || ($user->hasRole('patient') && $user->patient && $rendezVous->patient_id === $user->patient->id)
            || ($user->hasRole('medecin') && $user->medecin && $rendezVous->medecin_id === $user->medecin->id),
            403
        );

        $validated = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'medecin_id' => 'required|exists:medecins,id',
            'date' => 'required|date',
            'heure' => 'required',
            'statut' => 'required|string|max:50',
        ]);
        $previousStatus = $rendezVous->statut;

        if (!$user->hasRole('admin')) {
            unset($validated['patient_id']);
        }

        if (
            Schema::hasColumn('rendez_vous', 'points_cost')
            && (
                ! Schema::hasColumn('rendez_vous', 'patient_points_spent')
                || ! $rendezVous->patient_points_spent
            )
        ) {
            $selectedMedecin = Medecin::find($validated['medecin_id']);

            if ($selectedMedecin) {
                $validated['points_cost'] = $this->getMedecinAppointmentCost($selectedMedecin);
            }
        }

        $this->rendezVousRepository->update($rendezVous, $validated);
        $rendezVous->refresh();
        $chargeError = $this->chargePatientPointsIfEligible($rendezVous);

        if ($chargeError) {
            $this->rendezVousRepository->update($rendezVous, ['statut' => $previousStatus]);

            return back()->withErrors([
                'statut' => $chargeError,
            ])->withInput();
        }

        $this->awardMedecinPointsIfEligible($rendezVous);
        $this->sendConfirmationEmailIfEligible($rendezVous, $previousStatus);

        return redirect()->route('rendezvous.index')
                         ->with('success', 'Rendez-vous modifié');
    }

    public function updateStatus(Request $request, string $id)
    {
        $rendezVous = $this->rendezVousRepository->findById($id);
        $user = auth()->user();

        abort_unless(
            $user->hasRole('admin')
            || ($user->hasRole('medecin') && $user->medecin && $rendezVous->medecin_id === $user->medecin->id),
            403
        );

        $validated = $request->validate([
            'statut' => 'required|in:confirme,annule,en_attente',
        ]);
        $previousStatus = $rendezVous->statut;

        $this->rendezVousRepository->update($rendezVous, [
            'statut' => $validated['statut'],
        ]);
        $rendezVous->refresh();
        $chargeError = $this->chargePatientPointsIfEligible($rendezVous);

        if ($chargeError) {
            $this->rendezVousRepository->update($rendezVous, ['statut' => $previousStatus]);

            return redirect()->route('dashboard')->withErrors([
                'statut' => $chargeError,
            ]);
        }

        $this->awardMedecinPointsIfEligible($rendezVous);
        $this->sendConfirmationEmailIfEligible($rendezVous, $previousStatus);

        return redirect()->route('dashboard')->with('success', 'Statut du rendez-vous mis a jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rendezVous = $this->rendezVousRepository->findById($id);
        $user = auth()->user();

        /* C'est une function pour arreter l'execution si un condition ne travaille pas */
        abort_unless(
            $user->hasRole('admin')
            || ($user->hasRole('patient') && $user->patient && $rendezVous->patient_id === $user->patient->id)
            || ($user->hasRole('medecin') && $user->medecin && $rendezVous->medecin_id === $user->medecin->id),
            403
        );

        $this->rendezVousRepository->delete($rendezVous);

        return redirect()->route('rendezvous.index')
                         ->with('success', 'Rendez-vous supprimé');
    }
}
