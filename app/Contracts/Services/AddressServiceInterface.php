<?php

namespace App\Contracts\Services;

use App\Models\Address;

interface AddressServiceInterface
{
    public function findAddressByZip(string $zipCode): array;
    public function saveAddress(int $userId, string $zipCode): Address;
}
