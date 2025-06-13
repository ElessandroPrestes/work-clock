<?php

namespace App\Contracts\Services;

use App\Models\ClockRecord;
use Illuminate\Support\Collection;

interface ClockRecordServiceInterface
{
    public function registrar(int $userId): ClockRecord;
    public function registrosDoUsuario(int $userId): Collection;
}
