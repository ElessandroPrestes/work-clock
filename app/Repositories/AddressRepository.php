<?php

namespace App\Repositories\Eloquent;

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
