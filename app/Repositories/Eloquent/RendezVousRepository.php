<?php

namespace App\Repositories\Eloquent;

use App\Models\RendezVous;
use App\Models\User;
use App\Repositories\Contracts\RendezVousRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RendezVousRepository implements RendezVousRepositoryInterface
{
    public function getForUser(User $user): Collection
    {
        $query = RendezVous::query()->orderBy('date')->orderBy('heure');

        if ($user->hasRole('admin')) {
            return $query->with(['patient.user', 'medecin.user'])->get();
        }

        if ($user->hasRole('patient') && $user->patient) {
            return $query
                ->where('patient_id', $user->patient->id)
                ->with(['medecin.user'])
                ->get();
        }

        if ($user->hasRole('medecin') && $user->medecin) {
            return $query
                ->where('medecin_id', $user->medecin->id)
                ->with(['patient.user'])
                ->get();
        }

        return collect();
    }

    public function findById(string $id): RendezVous
    {
        return RendezVous::findOrFail($id);
    }

    public function create(array $data): RendezVous
    {
        return RendezVous::create($data);
    }

    public function update(RendezVous $rendezVous, array $data): bool
    {
        return $rendezVous->update($data);
    }

    public function delete(RendezVous $rendezVous): ?bool
    {
        return $rendezVous->delete();
    }
}
