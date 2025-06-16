<?php

namespace App\Contracts\Services;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    public function create(array $data, ?int $managerId = null): User;
    public function update(User $user, array $data): bool;
    public function delete(User $user): bool;
    public function getAll(): Collection;
    public function getById(int $id): ?User;
    public function getSubordinates(int $managerId): Collection;
}
