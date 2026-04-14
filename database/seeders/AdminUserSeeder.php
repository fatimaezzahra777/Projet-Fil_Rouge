<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'nom' => env('ADMIN_NOM'),
                'prenom' => env('ADMIN_PRENOM'),
                'telephone' => env('ADMIN_TELEPHONE'),
                'ville' => env('ADMIN_VILLE', 'Casablanca'),
                'genre' => env('ADMIN_GENRE'),
                'role' => 'admin',
                'password' => Hash::make(env('ADMIN_PASSWORD')),
                'email_verified_at' => now(),
            ]
        );

        Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        if (! $user->hasRole('admin')) {
            $user->assignRole('admin');
        }
    }
}
