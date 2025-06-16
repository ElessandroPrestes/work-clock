<?php

namespace App\Contracts\Repositories;

use App\Models\Address;

interface AddressRepositoryInterface
{
    public function save(int $userId, array $addressData): Address;
}
