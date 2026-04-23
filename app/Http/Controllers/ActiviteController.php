<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use App\Models\Participation;
use App\Models\User;
use App\Notifications\NewActivityNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class ActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        Activite::Fin();

        if ($user && $user->hasRole('association') && $user->association) {
            $activites = Activite::with('association.user')
                ->where('association_id', $user->association->id)
                ->with(['participations.patient.user'])
                ->orderBy('date')
                ->orderBy('id')
                ->get();
            $participations = Participation::query()
                ->with(['patient.user', 'activite'])
                ->whereHas('activite', function ($query) use ($user) {
                    $query->where('association_id', $user->association->id);
                })
                ->latest()
                ->get();
        } else {
            $activites = Activite::with(['association.user', 'participations'])
                ->orderBy('date')
                ->orderBy('id')
                ->get();
            $participations = $user && $user->hasRole('patient') && $user->patient
                ? Participation::query()
                    ->where('patient_id', $user->patient->id)
                    ->get()
                    ->keyBy('activite_id')
                : collect();
        }

        return view('activites.index', [
            'user' => $user,
            'activites' => $activites,
            'participations' => $participations,
            'stats' => [
                'total' => $activites->count(),
                'avenir' => $activites->where('date', '>=', now()->toDateString())->count(),
                'points' => $activites->sum('points'),
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        abort_unless($user && $user->hasRole('association') && $user->association, 403);

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'points' => 'required|integer|min:1'
        ]);

        $activite = Activite::create([
            'association_id' => $user->association->id,
            'titre' => $request->titre,
            'description' => $request->description,
            'date' => $request->date,
            'points' => $request->points
        ]);

        $activite->load('association');

        if (Schema::hasTable('notifications')) {
            User::query()
                ->where('role', 'patient')
                ->get()
                ->each(function (User $patientUser) use ($activite) {
                    $patientUser->notify(new NewActivityNotification($activite));
                });
        }

        return redirect()->route('dashboard')->with('success', 'Activite creee avec succes.');
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
        $user = auth()->user();
        $activite = Activite::findOrFail($id);

        abort_unless(
            $user && ($user->hasRole('admin') || ($user->hasRole('association') && $user->association && $activite->association_id === $user->association->id)),
            403
        );

        $activite->delete();

        return back()->with('success', 'Activite supprimee avec succes.');
    }
}
