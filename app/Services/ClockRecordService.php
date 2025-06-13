<?php

namespace App\Services;

use App\Contracts\Repositories\ClockRecordRepositoryInterface;
use App\Contracts\Services\ClockRecordServiceInterface;
use App\Models\ClockRecord;

class ClockRecordService implements ClockRecordServiceInterface
{
    public function __construct(
        private ClockRecordRepositoryInterface $repository
    ) {}

    public function registrar(int $userId): ClockRecord
    {
        return $this->repository->registrar($userId);
    }

    public function registrosDoUsuario(int $userId): \Illuminate\Support\Collection
    {
        return $this->repository->listarPorUsuario($userId);
    }
}

