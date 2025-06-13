<?php

namespace App\Contracts\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface
{
    public function getAll(): Collection;
    public function find(int $id): ?User;
    public function store(array $data): User;
    public function update(User $funcionario, array $data): User;
    public function delete(User $funcionario): void;
}
