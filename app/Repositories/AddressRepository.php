<?php

namespace App\Repositories;

use App\Contracts\Repositories\AddressRepositoryInterface;
use App\Models\Address;

class AddressRepository implements AddressRepositoryInterface
{
    public function save(int $userId, array $addressData): Address
    {
        return Address::updateOrCreate(
            ['user_id' => $userId],
            $addressData
        );
    }
}
