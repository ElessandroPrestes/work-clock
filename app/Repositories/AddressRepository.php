<?php

namespace App\Repositories;

use App\Contracts\Repositories\AddressRepositoryInterface;
use App\Models\Address;

class AddressRepository implements AddressRepositoryInterface
{
    public function salvar(int $userId, array $dadosEndereco): Address
    {
        return Address::updateOrCreate(
            ['user_id' => $userId],
            $dadosEndereco
        );
    }
}
