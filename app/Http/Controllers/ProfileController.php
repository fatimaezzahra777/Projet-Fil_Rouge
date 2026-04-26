<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Association;
use App\Models\Medecin;
use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user()->load(['patient', 'medecin', 'association']),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user()->load(['patient', 'medecin', 'association']);
        $validated = $request->validated();

        $user->fill([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'telephone' => $validated['telephone'] ?? null,
            'ville' => $validated['ville'] ?? null,
            'genre' => $validated['genre'] ?? null,
            'date_naissance' => $validated['date_naissance'] ?? null,
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($user->hasRole('patient')) {
            Patient::query()->firstOrCreate(
                ['user_id' => $user->id],
                ['type_addiction' => $validated['type_addiction'] ?? null]
            )->update([
                'type_addiction' => $validated['type_addiction'] ?? null,
            ]);
        }

        if ($user->hasRole('medecin')) {
            Medecin::query()->firstOrCreate(
                ['user_id' => $user->id],
                ['specialite' => $validated['specialite'] ?? null]
            )->update([
                'specialite' => $validated['specialite'] ?? null,
            ]);
        }

        if ($user->hasRole('association')) {
            Association::query()->firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nom' => $validated['association_nom'] ?? trim(($user->prenom ?? '') . ' ' . ($user->nom ?? '')),
                    'description' => $validated['association_description'] ?? null,
                ]
            )->update([
                'nom' => $validated['association_nom'] ?? trim(($user->prenom ?? '') . ' ' . ($user->nom ?? '')),
                'description' => $validated['association_description'] ?? null,
            ]);
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
