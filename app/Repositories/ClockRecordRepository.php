<?php

namespace App\Repositories;

use App\Contracts\Repositories\ClockRecordRepositoryInterface;
use App\Models\ClockRecord;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function obterRelatorio(string $start, string $end): array
{
    return DB::select("
        SELECT cr.id AS registro_id,
               u.name AS funcionario,
               u.cargo,
               TIMESTAMPDIFF(YEAR, u.data_nascimento, CURDATE()) AS idade,
               g.name AS gestor,
               cr.created_at AS data_hora
        FROM clock_records cr
        INNER JOIN users u ON cr.user_id = u.id
        LEFT JOIN users g ON u.gestor_id = g.id
        WHERE cr.created_at BETWEEN ? AND ?
        ORDER BY cr.created_at DESC
    ", [$start, $end]);
}

}
