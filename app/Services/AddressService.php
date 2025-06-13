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

    public function buscarEnderecoViaCep(string $cep): array
    {
        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->failed() || isset($response['erro'])) {
            throw new \Exception('CEP inválido.');
        }

        return [
            'rua' => $response['logradouro'] ?? '',
            'bairro' => $response['bairro'] ?? '',
            'cidade' => $response['localidade'] ?? '',
            'estado' => $response['uf'] ?? '',
        ];
    }

    public function salvarEndereco(int $userId, string $cep): Address
    {
        $endereco = $this->buscarEnderecoViaCep($cep);
        return $this->repository->salvar($userId, $endereco);
    }
}
