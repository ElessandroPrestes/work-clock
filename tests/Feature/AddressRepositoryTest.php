<?php

use App\Models\User;
use App\Models\Address;
use App\Repositories\AddressRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

beforeEach(function () {
    $this->repositorio = app(AddressRepository::class);
    $this->usuario = User::factory()->create();
});

it('cria um endereço novo para o usuário', function () {
    $dados = [
        'street' => 'Rua das Palmeiras',
        'neighborhood' => 'Centro',
        'city' => 'Foz do Iguaçu',
        'state' => 'PR',
        'zip_code' => '85800-000',
    ];

    $endereco = $this->repositorio->save($this->usuario->id, $dados);

    expect($endereco)->toBeInstanceOf(Address::class)
        ->and($endereco->user_id)->toBe($this->usuario->id)
        ->and($endereco->city)->toBe('Foz do Iguaçu');

    // Verifica que o endereço foi persistido no banco
    $this->assertDatabaseHas('addresses', [
        'user_id' => $this->usuario->id,
        'street' => 'Rua das Palmeiras',
        'neighborhood' => 'Centro',
        'city' => 'Foz do Iguaçu',
    ]);
});

it('atualiza o endereço existente do usuário', function () {
    Address::factory()->create([
        'user_id' => $this->usuario->id,
        'street' => 'Rua Antiga',
        'neighborhood' => 'Centro',
        'city' => 'Cidade Antiga',
        'state' => 'PR',
        'zip_code' => '85000-000',
    ]);

    $dadosAtualizados = [
        'street' => 'Rua Atualizada',
        'city' => 'Londrina',
        'neighborhood' => 'Centro',
        'state' => 'PR',
        'zip_code' => '86000-000',
    ];

    $atualizado = $this->repositorio->save($this->usuario->id, $dadosAtualizados);

    expect($atualizado->street)->toBe('Rua Atualizada')
        ->and($atualizado->city)->toBe('Londrina');

    // Verifica que só existe 1 endereço para o usuário
    $this->assertEquals(1, Address::where('user_id', $this->usuario->id)->count());

    // Verifica que o endereço no banco foi atualizado
    $this->assertDatabaseHas('addresses', [
        'user_id' => $this->usuario->id,
        'street' => 'Rua Atualizada',
        'city' => 'Londrina',
        'neighborhood' => 'Centro',
    ]);
});
