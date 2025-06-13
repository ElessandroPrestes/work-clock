<?php

namespace App\Contracts\Services;

use App\Models\Address;

interface AddressServiceInterface
{
    public function buscarEnderecoViaCep(string $cep): array;
    public function salvarEndereco(int $userId, string $cep): Address;
}
