<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function create(array $data): User;
    public function getById(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function update(User $user, array $data): bool;
    public function delete(User $user): bool;
    public function getAll(): Collection;
}
