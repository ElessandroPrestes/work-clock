<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'cpf' => $this->cpf,
            'email' => $this->email,
            'cargo' => $this->cargo,
            'data_nascimento' => $this->data_nascimento->format('Y-m-d'),
            'cep' => $this->cep,
            'endereco' => [
                'rua' => $this->endereco->rua ?? null,
                'bairro' => $this->endereco->bairro ?? null,
                'cidade' => $this->endereco->cidade ?? null,
                'estado' => $this->endereco->estado ?? null,
            ],
            'gestor_id' => $this->gestor_id,
        ];
    }
}
