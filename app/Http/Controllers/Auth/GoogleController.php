<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class GoogleController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')
            ->redirect();
    }

    public function callback(): RedirectResponse
    {
        
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = DB::transaction(function () use ($googleUser) {
            $existingUser = User::where('google_id', $googleUser->getId())
                ->orWhere('email', $googleUser->getEmail())
                ->first();

            if ($existingUser) {
                $existingUser->update([
                    'google_id' => $googleUser->getId(),
                    'google_avatar' => $googleUser->getAvatar(),
                    'email_verified_at' => $existingUser->email_verified_at ?? now(),
                ]);

                if ($existingUser->role === 'patient' && !$existingUser->patient) {
                    Patient::create([
                        'user_id' => $existingUser->id,
                    ]);
                }

                return $existingUser;
            }

            $fullName = trim((string) $googleUser->getName());
            $nameParts = preg_split('/\s+/', $fullName, 2) ?: [];
            $prenom = $nameParts[0] ?? 'Google';
            $nom = $nameParts[1] ?? $prenom;

            $user = User::create([
                'nom' => $nom,
                'prenom' => $prenom,
                'role' => 'patient',
                'email' => $googleUser->getEmail(),
                'email_verified_at' => now(),
                'google_id' => $googleUser->getId(),
                'google_avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(Str::random(40)),
            ]);

            Role::firstOrCreate([
                'name' => 'patient',
                'guard_name' => 'web',
            ]);

            $user->assignRole('patient');

            Patient::create([
                'user_id' => $user->id,
            ]);

            return $user;
        });

        Auth::login($user);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
