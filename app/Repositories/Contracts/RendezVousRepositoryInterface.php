<?php

namespace App\Repositories\Contracts;

use App\Models\RendezVous;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface RendezVousRepositoryInterface
{
    public function getForUser(User $user): Collection;

    public function findById(string $id): RendezVous;

    public function create(array $data): RendezVous;

    public function update(RendezVous $rendezVous, array $data): bool;

    public function delete(RendezVous $rendezVous): ?bool;
}
