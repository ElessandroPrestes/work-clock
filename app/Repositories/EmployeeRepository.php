<?php

namespace App\Repositories;

use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function getAll(): Collection
    {
        return User::whereNotNull('gestor_id')->get(); // Ignora admins
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function store(array $data): User
    {
        return User::create($data);
    }

    public function update(User $funcionario, array $data): User
    {
        $funcionario->update($data);
        return $funcionario;
    }

    public function delete(User $funcionario): void
    {
        $funcionario->delete();
    }
}
