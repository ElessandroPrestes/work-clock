<?php

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);


beforeEach(function () {
    $this->repositorio = new UserRepository();
});

it('cria um novo usuário', function () {
    $dados = User::factory()->make()->toArray();

    $usuario = $this->repositorio->create($dados);

    expect($usuario)->toBeInstanceOf(User::class)
        ->and(User::find($usuario->id))->not->toBeNull();
});

it('retorna apenas usuários com papel de funcionário', function () {
    User::factory()->count(2)->create(['role' => 'employee']);
    User::factory()->create(['role' => 'admin']);

    $funcionarios = $this->repositorio->allEmployees();

    expect($funcionarios)->toHaveCount(2)
        ->and($funcionarios->pluck('role')->unique()->sole())->toBe('employee');
});

it('retorna os funcionários gerenciados por um gestor específico', function () {
    $gestor = User::factory()->create();
    User::factory()->count(2)->create([
        'role' => 'employee',
        'manager_id' => $gestor->id,
    ]);
    User::factory()->create(['role' => 'employee']); 

    $resultado = $this->repositorio->allByManager($gestor->id);

    expect($resultado)->toHaveCount(2)
        ->and($resultado->pluck('manager_id')->unique()->sole())->toBe($gestor->id);
});

it('encontra um usuário pelo e-mail', function () {
    $usuario = User::factory()->create();

    $encontrado = $this->repositorio->findByEmail($usuario->email);

    expect($encontrado)->not->toBeNull()
        ->and($encontrado->id)->toBe($usuario->id);
});

it('recupera um usuário com endereço pelo ID', function () {
    $usuario = User::factory()->hasAddress()->create();

    $carregado = $this->repositorio->getById($usuario->id);

    expect($carregado)->not->toBeNull()
        ->and($carregado->relationLoaded('address'))->toBeTrue();
});

it('atualiza os dados de um usuário', function () {
    $usuario = User::factory()->create();

    $resultado = $this->repositorio->update($usuario, ['name' => 'Atualizado']);

    expect($resultado)->toBeTrue()
        ->and($usuario->fresh()->name)->toBe('Atualizado');
});

it('remove um usuário', function () {
    $usuario = User::factory()->create();

    $resultado = $this->repositorio->delete($usuario);

    expect($resultado)->toBeTrue()
        ->and(User::find($usuario->id))->toBeNull();
});

it('retorna todos os usuários cadastrados', function () {
    User::factory()->count(4)->create();

    $usuarios = $this->repositorio->getAll();

    expect($usuarios)->toHaveCount(4);
});
