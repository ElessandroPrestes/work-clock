<?php

namespace App\Repositories;

use App\Contracts\Repositories\ClockRecordRepositoryInterface;
use App\Models\ClockRecord;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ClockRecordRepository implements ClockRecordRepositoryInterface
{
    public function register(int $userId): ClockRecord
    {
        return ClockRecord::create(['user_id' => $userId]);
    }

    public function listByUser(int $userId): Collection
    {
        return ClockRecord::where('user_id', $userId)->get();
    }

    public function getReport(string $start, string $end): array
{
    return DB::select("
        SELECT cr.id AS registro_id,
                   u.name AS funcionario,
                   u.position,
                   TIMESTAMPDIFF(YEAR, u.birthdate, CURDATE()) AS idade,
                   g.name AS gestor,
                   cr.created_at AS data_hora
            FROM clock_records cr
            INNER JOIN users u ON cr.user_id = u.id
            LEFT JOIN users g ON u.manager_id = g.id
            WHERE cr.created_at BETWEEN ? AND ?
            ORDER BY cr.created_at DESC
    ", [$start, $end]);
}

}
