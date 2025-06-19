<?php

namespace App\Repositories;

use App\Contracts\Repositories\ClockRecordRepositoryInterface;
use App\Models\ClockRecord;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ClockRecordRepository implements ClockRecordRepositoryInterface
{
    public function register(int $userId): ClockRecord
    {
        return ClockRecord::create(['user_id' => $userId, 'recorded_at' => Carbon::now()]);
    }

    public function listByUser(int $userId): Collection
    {
        return ClockRecord::where('user_id', $userId)->get();
    }

    public function getReport(string $startDate, string $endDate): array
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            $query = <<<SQL
                SELECT cr.id AS registro_id,
                    u.name AS funcionario,
                    u.position,
                    CAST((julianday('now') - julianday(u.birthdate)) / 365.25 AS INT) AS idade,
                    g.name AS gestor,
                    cr.created_at AS data_hora
                FROM clock_records cr
                INNER JOIN users u ON cr.user_id = u.id
                LEFT JOIN users g ON u.manager_id = g.id
                WHERE cr.created_at BETWEEN ? AND ?
                ORDER BY cr.created_at DESC
            SQL;
        } else {
            $query = <<<SQL
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
            SQL;
        }

        return DB::select($query, [$startDate, $endDate]);
    }
}
