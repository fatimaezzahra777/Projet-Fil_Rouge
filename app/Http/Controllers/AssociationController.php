<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Association;

class AssociationController extends Controller
{
    /**
     * Display a listing of the resource.
     * Est une function pour returner le view association index si le role association 
     */
    public function index()
    {
        abort_unless(auth()->user()?->hasRole('admin'), 403);

        $associations = Association::with('user')->get();
        return view('associations.index', compact('associations'));
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

        $association = Association::with('user')->findOrFail($id);
        return view('associations.show', compact('association'));
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

        $association = Association::findOrFail($id);
        $association->update(['is_validated' => true]);

        return back()->with('success', 'Association validée');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
