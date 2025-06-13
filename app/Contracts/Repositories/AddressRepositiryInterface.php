<?php

namespace App\Contracts\Repositories;

use App\Models\Address;

interface AddressRepositoryInterface
{
    public function salvar(int $userId, array $dadosEndereco): Address;
}
