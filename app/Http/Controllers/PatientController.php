<?php

namespace App\Http\Controllers;

use App\Models\Participation;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\TransactionPoint;
use Illuminate\Contracts\View\View;

class PatientController extends Controller
{
    public function dossier(Request $request): View
    {
        \App\Models\Activite::Fin();
        $user = $request->user()->load('patient');

        abort_unless($user->hasRole('patient') && $user->patient, 403);

        $patient = $user->patient;
        $rendezVous = RendezVous::where('patient_id', $patient->id)
            ->with(['medecin.user'])
            ->orderByDesc('date')
            ->orderByDesc('heure')
            ->get();

        $transactions = TransactionPoint::where('patient_id', $patient->id)
            ->latest()
            ->take(6)
            ->get();

        $participations = Participation::where('patient_id', $patient->id)
            ->with(['activite.association'])
            ->latest()
            ->take(6)
            ->get();

        $medecins = $rendezVous
            ->pluck('medecin')
            ->filter()
            ->unique('id')
            ->values();

        $profileFields = [
            $user->nom,
            $user->prenom,
            $user->email,
            $user->telephone,
            $user->ville,
            $user->genre,
            $user->date_naissance,
            $patient->type_addiction,
        ];

        $completion = (int) round((collect($profileFields)->filter(fn ($value) => filled($value))->count() / count($profileFields)) * 100);
        $confirmedAppointments = $rendezVous->whereIn('statut', ['confirme', 'confirmé'])->count();
        $regularite = $rendezVous->count() > 0 ? (int) round(($confirmedAppointments / $rendezVous->count()) * 100) : 0;
        $participationRate = (int) min(100, $participations->count() * 20);
        $globalProgress = (int) round(($completion + $regularite + $participationRate) / 3);
        $age = $user->date_naissance ? now()->diffInYears($user->date_naissance) : null;

        return view('patient.index', [
            'user' => $user,
            'patient' => $patient,
            'rendezVous' => $rendezVous,
            'transactions' => $transactions,
            'participations' => $participations,
            'medecins' => $medecins,
            'completion' => $completion,
            'regularite' => $regularite,
            'participationRate' => $participationRate,
            'globalProgress' => $globalProgress,
            'age' => $age,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::with('user')->get();
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::with('user')->findOrFail($id);
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Patient::findOrFail($id)->delete();
        return redirect()->route('patients.index');
    }
}
