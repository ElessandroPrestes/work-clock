<?php

namespace App\Services;

use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Services\EmployeeServiceInterface;
use App\Models\User;
use Illuminate\Support\Collection;
use App\Exceptions\ApiException;
use App\Enums\HttpStatus;

class EmployeeService implements EmployeeServiceInterface
{
    public function __construct(private EmployeeRepositoryInterface $repository) {}

    public function getAll(): Collection
    {
        return $this->repository->listar();
    }

    public function find(int $id): User
    {
        $funcionario = $this->repository->find($id);
        if (!$funcionario) {
            throw new ApiException("Funcionário não encontrado", HttpStatus::NOT_FOUND);
        }
        return $funcionario;
    }

    public function store(array $data): User
    {
        return $this->repository->store($data);
    }

    public function update(User $funcionario, array $data): User
    {
        return $this->repository->update($funcionario, $data);
    }

    public function delete(User $funcionario): void
    {
        $this->repository->delete($funcionario);
    }
}
