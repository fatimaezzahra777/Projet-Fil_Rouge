<?php

namespace App\Http\Controllers;

use App\Models\Activite;
use Illuminate\Http\Request;

class ActiviteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $activites = Activite::with('association.user')->get();
        return view('activites.index', compact('activites'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activites.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required',
            'description' => 'required',
            'date' => 'required|date',
            'points' => 'required|integer'
        ]);

        $user = auth()->user();

        Activite::create([
            'association_id' => $user->association->id,
            'titre' => $request->titre,
            'description' => $request->description,
            'date' => $request->date,
            'points' => $request->points
        ]);

        return redirect()->route('activites.index');
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
        Activite::findOrFail($id)->delete();
        return back();
    }
}
