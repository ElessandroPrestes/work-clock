<?php

namespace App\Contracts\Repositories;

use App\Models\ClockRecord;
use Illuminate\Support\Collection;

interface ClockRecordRepositoryInterface
{
    public function register(int $userId): ClockRecord;
    public function listByUser(int $userId): Collection;
    public function getReport(string $start, string $end): array;
}
