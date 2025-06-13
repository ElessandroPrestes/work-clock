<?php

namespace App\Contracts\Services;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    public function cadastrar(array $data): User;
    public function atualizar(User $user, array $data): bool;
    public function deletar(User $user): bool;
    public function listar(): Collection;
}
