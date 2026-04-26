<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Association;
use App\Models\Medecin;
use App\Models\Participation;
use App\Models\RendezVous;
use App\Models\TransactionPoint;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        Activite::Fin();
        $user = $request->user()->load(['association', 'patient', 'medecin']);
        $association = null;
        $activites = collect();
        $stats = [];
        $patientStats = null;
        $patientAppointments = collect();
        $patientTransactions = collect();
        $availableActivities = collect();
        $patientProgress = [];
        $patientMessages = collect();
        $patientNotifications = collect();
        $patientUnreadNotifications = 0;
        $doctorSearch = '';
        $doctorResults = collect();
        $topMedecins = collect();
        $medecinStats = null;
        $medecinAppointments = collect();
        $adminStats = null;
        $adminUsers = collect();
        $pendingMedecins = collect();
        $pendingAssociations = collect();

        if ($user->hasRole('association') && $user->association){
            $association = $user->association;
            $activites = Activite::where('association_id', $association->id)
                ->latest('date')
                ->latest('id')
                ->get();

            $stats = [
                'total' => $activites->count(),
                'avenir' => $activites->where('date', '>=', now()->toDateString())->count(),
                'points' => $activites->sum('points'),
            ];
        }

        if ($user->hasRole('patient') && $user->patient) {
            $patient = $user->patient;
            $doctorSearch = trim((string) $request->string('doctor_search'));

            $patientAppointments = RendezVous::where('patient_id', $patient->id)
                ->with(['medecin.user'])
                ->whereDate('date', '>=', now()->toDateString())
                ->orderBy('date')
                ->orderBy('heure')
                ->take(3)
                ->get();

            $allAppointments = RendezVous::where('patient_id', $patient->id)->get();
            $patientTransactions = TransactionPoint::where('patient_id', $patient->id)
                ->latest()
                ->take(4)
                ->get();

            $participationsCount = Participation::where('patient_id', $patient->id)->count();
            $availableActivities = Activite::with('association')
                ->whereDate('date', '>=', now()->toDateString())
                ->orderBy('date')
                ->take(3)
                ->get();

            $confirmedAppointments = $allAppointments->whereIn('statut', ['confirme', 'confirmé'])->count();
            $appointmentTotal = $allAppointments->count();
            $regularite = $appointmentTotal > 0 ? (int) round(($confirmedAppointments / $appointmentTotal) * 100) : 0;
            $atelierProgress = $availableActivities->count() > 0
                ? (int) min(100, round(($participationsCount / max(1, $availableActivities->count())) * 100))
                : min(100, $participationsCount * 20);
            $communityProgress = (int) min(100, max(0, $patientTransactions->where('type', 'gain')->sum('montant')));
 
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
            $completedFields = collect($profileFields)->filter(fn ($value) => filled($value))->count();
            $dossierProgress = (int) round(($completedFields / count($profileFields)) * 100);

            $globalProgress = (int) round(($regularite + $atelierProgress + $communityProgress + $dossierProgress) / 4);

            $points = (int) ($patient->points ?? 0);
            $nextLevelTarget = 1000;
            $patientStats = [
                'points' => $points,
                'rendezvous_total' => $appointmentTotal,
                'rendezvous_upcoming' => $patientAppointments->count(),
                'participations_total' => $participationsCount,
                'global_progress' => $globalProgress,
                'level_label' => $points >= 2000 ? 'Or' : ($points >= 1000 ? 'Argent' : 'Bronze'),
                'next_level_target' => $nextLevelTarget,
                'level_progress' => min(100, (int) round(($points / $nextLevelTarget) * 100)),
            ];

            $patientProgress = [
                'Regularite des rendez-vous' => $regularite,
                'Participation aux ateliers' => $atelierProgress,
                'Aide a la communaute' => $communityProgress,
                'Dossier complet' => $dossierProgress,
            ];

            $patientMessages = collect([
                [
                    'initials' => 'SC',
                    'name' => 'Second Chance',
                    'preview' => $patientAppointments->count() > 0
                        ? 'Vous avez ' . $patientAppointments->count() . ' rendez-vous a venir.'
                        : 'Continuez votre parcours, de nouvelles activites arrivent bientot.',
                    'time' => 'Aujourd\'hui',
                ],
                [
                    'initials' => 'PT',
                    'name' => 'Programme',
                    'preview' => $participationsCount > 0
                        ? 'Vous avez participe a ' . $participationsCount . ' activites jusqu\'a present.'
                        : 'Votre premiere activite peut vous faire gagner des points.',
                    'time' => 'Recap',
                ],
            ]);

            if (Schema::hasTable('notifications')) {
                $patientNotifications = $user->notifications()
                    ->latest()
                    ->take(5)
                    ->get();

                $patientUnreadNotifications = $user->unreadNotifications()->count();
            }

            $doctorResults = Medecin::query()
                ->with('user')
                ->where('is_validated', true)
                ->when($doctorSearch !== '', function ($query) use ($doctorSearch) {
                    $query->where(function ($subQuery) use ($doctorSearch) {
                        $subQuery
                            ->where('specialite', 'like', '%' . $doctorSearch . '%')
                            ->orWhereHas('user', function ($userQuery) use ($doctorSearch) {
                                $userQuery
                                    ->where('prenom', 'like', '%' . $doctorSearch . '%')
                                    ->orWhere('nom', 'like', '%' . $doctorSearch . '%')
                                    ->orWhere('ville', 'like', '%' . $doctorSearch . '%')
                                    ->orWhere('email', 'like', '%' . $doctorSearch . '%');
                            });
                    });
                })
                ->orderBy('specialite')
                ->orderBy(
                    User::select('prenom')
                        ->whereColumn('users.id', 'medecins.user_id')
                        ->limit(1)
                )
                ->take(6)
                ->get();

            $topMedecins = Medecin::with('user')
                ->where('is_validated', true)
                ->orderByDesc('points')
                ->orderByDesc('id')
                ->take(3)
                ->get();
        }

        if ($user->hasRole('medecin') && $user->medecin) {
            $medecinAppointments = RendezVous::where('medecin_id', $user->medecin->id)
                ->with(['patient.user'])
                ->orderBy('date')
                ->orderBy('heure')
                ->get();
            $appointmentPointsCost = Schema::hasColumn('medecins', 'appointment_points_cost')
                ? (int) ($user->medecin->appointment_points_cost ?? Medecin::DEFAULT_APPOINTMENT_POINTS_COST)
                : Medecin::DEFAULT_APPOINTMENT_POINTS_COST;

            $medecinStats = [
                'earned_points' => (int) ($user->medecin->points ?? 0),
                'appointment_points_cost' => max(1, $appointmentPointsCost),
                'total' => $medecinAppointments->count(),
                'today' => $medecinAppointments->where('date', now()->toDateString())->count(),
                'pending' => $medecinAppointments->where('statut', 'en_attente')->count(),
                'confirmed' => $medecinAppointments->whereIn('statut', ['confirme', 'confirmé'])->count(),
            ];
        }

        if ($user->hasRole('admin')) {
            $adminUsers = User::with(['patient', 'medecin', 'association'])
                ->latest()
                ->take(12)
                ->get();

            $pendingMedecins = Medecin::with('user')
                ->where('is_validated', false)
                ->latest()
                ->take(6)
                ->get();

            $pendingAssociations = Association::with('user')
                ->where('is_validated', false)
                ->latest()
                ->take(6)
                ->get();

            $adminStats = [
                'users_total' => User::count(),
                'patients_total' => User::where('role', 'patient')->count(),
                'medecins_pending' => Medecin::where('is_validated', false)->count(),
                'associations_pending' => Association::where('is_validated', false)->count(),
            ];
        }

        return view('dashboard', compact(
            'user',
            'association',
            'activites',
            'stats',
            'patientStats',
            'patientAppointments',
            'patientTransactions',
            'availableActivities',
            'patientProgress',
            'patientMessages',
            'patientNotifications',
            'patientUnreadNotifications',
            'doctorSearch',
            'doctorResults',
            'topMedecins',
            'medecinStats',
            'medecinAppointments',
            'adminStats',
            'adminUsers',
            'pendingMedecins',
            'pendingAssociations',
        ));
    }
}
