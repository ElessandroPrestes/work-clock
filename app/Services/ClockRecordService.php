<?php

namespace App\Services;

use App\Contracts\Repositories\ClockRecordRepositoryInterface;
use App\Contracts\Services\ClockRecordServiceInterface;
use App\Models\ClockRecord;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class ClockRecordService implements ClockRecordServiceInterface
{
    public function __construct(
        private ClockRecordRepositoryInterface $clockRecordRepository
    ) {}

    public function register(int $userId): ClockRecord
    {
        return $this->clockRecordRepository->register($userId);
    }

    public function userRecords(int $userId): Collection
    {
        return $this->clockRecordRepository->listByUser($userId);
    }

    public function generateReport(string $start, string $end): array
    {
        try {
            $startDate = Carbon::parse($start);
            $endDate = Carbon::parse($end);
        } catch (\Exception $e) {
            throw new InvalidArgumentException('As datas fornecidas são inválidas.');
        }

        if ($startDate->greaterThan($endDate)) {
            throw new InvalidArgumentException('A data final deve ser igual ou posterior à inicial.');
        }

        return $this->clockRecordRepository->getReport(
            $startDate->toDateString(),
            $endDate->toDateString()
        );
    }

}

