<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Association;
use App\Models\Medecin;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenom' => ['required', 'string', 'max:255'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'ville' => ['required', 'string', 'max:255'],
            'genre' => ['nullable', 'in:Homme,Femme'],
            'date_naissance' => ['nullable', 'date'],
            'role' => ['required', 'in:patient,medecin,association'],
            'type_addiction' => ['nullable', 'string', 'max:255'],
            'specialite' => ['nullable', 'required_if:role,medecin', 'string', 'max:255'],
            'appointment_points_cost' => ['nullable', 'required_if:role,medecin', 'integer', 'min:1'],
            'association_nom' => ['nullable', 'required_if:role,association', 'string', 'max:255'],
            'association_description' => ['nullable', 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'telephone' => $request->telephone,
                'ville' => $request->ville,
                'genre' => $request->genre,
                'date_naissance' => $request->date_naissance,
                'role' => $request->role,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            Role::firstOrCreate([
                'name' => $request->role,
                'guard_name' => 'web',
            ]);

            $user->assignRole($request->role);

            if ($request->role === 'patient') {
                Patient::create([
                    'user_id' => $user->id,
                    'type_addiction' => $request->type_addiction,
                ]);
            }

            if ($request->role === 'medecin') {
                $medecinData = [
                    'user_id' => $user->id,
                    'specialite' => $request->specialite,
                ];

                if (Schema::hasColumn('medecins', 'appointment_points_cost')) {
                    $medecinData['appointment_points_cost'] = (int) $request->appointment_points_cost;
                }

                Medecin::create($medecinData);
            }

            if ($request->role === 'association') {
                Association::create([
                    'user_id' => $user->id,
                    'nom' => $request->association_nom,
                    'description' => $request->association_description,
                ]);
            }

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
