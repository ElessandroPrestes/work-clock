<?php

namespace App\Services;

use App\Contracts\Repositories\AddressRepositoryInterface;
use App\Contracts\Services\AddressServiceInterface;
use Illuminate\Support\Facades\Http;
use App\Models\Address;

class AddressService implements AddressServiceInterface
{
    public function __construct(
        private AddressRepositoryInterface $repository
    ) {}

    public function findAddressByZip(string $cep): array
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->failed() || isset($response['erro'])) {
            throw new \Exception('CEP inválido.');
        }

        return [
            'street' => $response['logradouro'] ?? '',
            'neighborhood' => $response['bairro'] ?? '',
            'city' => $response['localidade'] ?? '',
            'state' => $response['uf'] ?? '',
        ];
    }

    public function saveAddress(int $userId, string $zipCode): Address
    {
        $address = $this->findAddressByZip($zipCode);
        return $this->repository->save($userId, $address);
    }
}
