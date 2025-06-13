<?php

namespace App\Contracts\Repositories;

use App\Models\ClockRecord;
use Illuminate\Support\Collection;

interface ClockRecordRepositoryInterface
{
    public function registrar(int $userId): ClockRecord;
    public function listarPorUsuario(int $userId): Collection;
    public function obterRelatorio(string $start, string $end): array;
}
