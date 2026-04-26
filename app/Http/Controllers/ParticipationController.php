<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activite;
use App\Models\Participation;


class ParticipationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request, string $id)
    {
        $user = auth()->user();
        abort_unless($user && $user->hasRole('patient') && $user->patient, 403);

        $activite = Activite::query()
            ->whereDate('date', '>=', now()->toDateString())
            ->findOrFail($id);

        $existingParticipation = Participation::query()
            ->where('patient_id', $user->patient->id)
            ->where('activite_id', $activite->id)
            ->first();

        if ($existingParticipation) {
            return back()->with('success', 'Vous avez deja postule a cette activite.');
        }

        Participation::create([
            'patient_id' => $user->patient->id,
            'activite_id' => $activite->id,
            'statut' => 'en_attente',
        ]);

        return back()->with('success', 'Votre demande de participation a ete envoyee.');
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
        $user = auth()->user();
        abort_unless($user && $user->hasRole('association') && $user->association, 403);

        $validated = $request->validate([
            'statut' => ['required', 'in:accepte,refuse'],
        ]);

        $participation = Participation::with('activite')->findOrFail($id);

        abort_unless(
            $participation->activite && $participation->activite->association_id === $user->association->id,
            403
        );

        $participation->update([
            'statut' => $validated['statut'],
        ]);

        return back()->with('success', 'La demande a ete mise a jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
