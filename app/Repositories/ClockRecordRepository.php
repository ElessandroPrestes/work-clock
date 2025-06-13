<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\ClockRecordRepositoryInterface;
use App\Models\ClockRecord;
use Illuminate\Support\Collection;

class ClockRecordRepository implements ClockRecordRepositoryInterface
{
    public function registrar(int $userId): ClockRecord
    {
        return ClockRecord::create(['user_id' => $userId]);
    }

    public function listarPorUsuario(int $userId): Collection
    {
        return ClockRecord::where('user_id', $userId)->get();
    }
}
