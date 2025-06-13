<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Models\User;

class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {}

    public function cadastrar(array $data): User
    {
        return $this->repository->create($data);
    }

    public function atualizar(User $user, array $data): bool
    {
        return $this->repository->update($user, $data);
    }

    public function deletar(User $user): bool
    {
        return $this->repository->delete($user);
    }

    public function listar(): \Illuminate\Support\Collection
    {
        return $this->repository->all();
    }
}
