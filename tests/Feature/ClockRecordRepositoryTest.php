<?php

use App\Models\User;
use App\Models\ClockRecord;
use App\Repositories\ClockRecordRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);


beforeEach(function () {
    $this->repositorio = new ClockRecordRepository();
});

it('registra um novo ponto para um usuário', function () {
    $usuario = User::factory()->create();

    $registro = $this->repositorio->register($usuario->id);

    expect($registro)->toBeInstanceOf(ClockRecord::class)
        ->and($registro->user_id)->toBe($usuario->id)
        ->and(ClockRecord::where('user_id', $usuario->id)->count())->toBe(1);
});

it('lista os registros de ponto de um usuário', function () {
    $usuario = User::factory()->create();
    ClockRecord::factory()->count(3)->create(['user_id' => $usuario->id]);

    $registros = $this->repositorio->listByUser($usuario->id);

    expect($registros)->toHaveCount(3)
        ->and($registros->pluck('user_id')->unique()->sole())->toBe($usuario->id);
});

it('gera relatório de ponto entre datas', function () {
    $gestor = User::factory()->create(['name' => 'Maria Líder']);
    $funcionario = User::factory()->create([
        'name' => 'Carlos Dev',
        'birthdate' => now()->subYears(28),
        'position' => 'Desenvolvedor',
        'manager_id' => $gestor->id,
    ]);

    ClockRecord::factory()->create([
        'user_id' => $funcionario->id,
        'created_at' => now()->subDays(1),
    ]);

    $resultado = $this->repositorio->getReport(
        now()->subDays(2)->toDateString(),
        now()->toDateString()
    );

    expect($resultado)->toBeArray()
        ->and($resultado)->toHaveCount(1)
        ->and($resultado[0]->funcionario)->toBe('Carlos Dev')
        ->and($resultado[0]->gestor)->toBe('Maria Líder')
        ->and($resultado[0]->idade)->toBe(28)
        ->and($resultado[0]->position)->toBe('Desenvolvedor')
        ->and($resultado[0]->registro_id)->not->toBeNull();
});