<?php

namespace App\Services;

use App\Contracts\Repositories\ClockRecordRepositoryInterface;
use App\Contracts\Services\ClockRecordServiceInterface;
use App\Models\ClockRecord;
use Illuminate\Support\Collection;

class ClockRecordService implements ClockRecordServiceInterface
{
    public function __construct(
        private ClockRecordRepositoryInterface $clockRecordRepository
    ) {}

    public function registrar(int $userId): ClockRecord
    {
        return $this->clockRecordRepository->registrar($userId);
    }

    public function registrosDoUsuario(int $userId): Collection
    {
        return $this->clockRecordRepository->listarPorUsuario($userId);
    }

    public function gerarRelatorio(string $start, string $end): array
    {
        return $this->clockRecordRepository->obterRelatorio($start, $end);
    }

}

