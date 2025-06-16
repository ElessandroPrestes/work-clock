<?php

namespace App\Contracts\Services;

use App\Models\ClockRecord;
use Illuminate\Support\Collection;

interface ClockRecordServiceInterface
{
    public function register(int $userId): ClockRecord;
    public function userRecords(int $userId): Collection;
    public function generateReport(string $start, string $end): array;
}
