<?php

namespace App\Repositories;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{

    public function allEmployees(): Collection
    {
        return User::where('role', 'employee')->get();
    }

    public function allByManager(int $managerId): Collection
    {
        return User::where('role', 'employee')->where('manager_id', $managerId)->get();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function getById(int $id): ?User
    {
        return User::with('address')->find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function getAll(): Collection
    {
        return User::all();
    }

}
