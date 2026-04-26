<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medecin;
use Illuminate\Support\Facades\Schema;

class MedecinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_unless(auth()->user()?->hasRole('admin'), 403);

        $medecins = Medecin::with('user')->get();
        return view('medecins.index', compact('medecins'));
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
        abort_unless(auth()->user()?->hasRole('admin'), 403);

        $medecin = Medecin::with('user')->findOrFail($id);
        return view('medecins.show', compact('medecin'));
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
        abort_unless(auth()->user()?->hasRole('admin'), 403);

        $medecin = Medecin::findOrFail($id);
        $medecin->update(['is_validated' => true]);

        return back()->with('success', 'Médecin validé');
    }

    public function updateAppointmentCost(Request $request)
    {
        $user = auth()->user();

        abort_unless($user?->hasRole('medecin') && $user->medecin, 403);

        $validated = $request->validate([
            'appointment_points_cost' => ['required', 'integer', 'min:1'],
        ]);

        if (! Schema::hasColumn('medecins', 'appointment_points_cost')) {
            return back()->withErrors([
                'appointment_points_cost' => 'La colonne du cout par rendez-vous n existe pas encore. Lancez php artisan migrate.',
            ]);
        }

        $user->medecin->update([
            'appointment_points_cost' => $validated['appointment_points_cost'],
        ]);

        return back()->with('success', 'Points par rendez-vous mis a jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
