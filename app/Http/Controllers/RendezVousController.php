<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RendezVous;
use App\Models\Patient;
use App\Models\Medecin;

class RendezVousController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $rendezVous = RendezVous::with(['patient.user', 'medecin.user'])->get();
        }

        elseif ($user->hasRole('patient')) {
            $rendezVous = RendezVous::where('patient_id', $user->patient->id)
                ->with(['medecin.user'])
                ->get();
        }

        elseif ($user->hasRole('medecin')) {
            $rendezVous = RendezVous::where('medecin_id', $user->medecin->id)
                ->with(['patient.user'])
                ->get();
        }

        return view('rendezvous.index', compact('rendezVous'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = Patient::with('user')->get();
        $medecins = Medecin::with('user')->get();

        return view('rendezvous.create', compact('patients', 'medecins'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'medecin_id' => 'required|exists:medecins,id',
            'date' => 'required|date',
            'heure' => 'required'
        ]);

        RendezVous::create([
            'patient_id' => $user->patient->id,
            'medecin_id' => $request->medecin_id,
            'date' => $request->date,
            'heure' => $request->heure,
            'statut' => 'en_attente'
        ]);

        return redirect()->route('rendezvous.index');
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
        $rendezVous = RendezVous::findOrFail($id);
        $patients = Patient::all();
        $medecins = Medecin::all();

        return view('rendezvous.edit', compact('rendezVous', 'patients', 'medecins'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rendezVous = RendezVous::findOrFail($id);

        $rendezVous->update($request->all());

        return redirect()->route('rendezvous.index')
                         ->with('success', 'Rendez-vous modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rendezVous = RendezVous::findOrFail($id);
        $rendezVous->delete();

        return redirect()->route('rendezvous.index')
                         ->with('success', 'Rendez-vous supprimé');
    }
}
