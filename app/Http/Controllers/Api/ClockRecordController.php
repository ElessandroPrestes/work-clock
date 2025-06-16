<?php


namespace App\Http\Controllers\Api;

use App\Contracts\Services\ClockRecordServiceInterface;
use App\Enums\HttpStatus;
use App\Exceptions\ApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClockRecordReportResource;

class ClockRecordController extends Controller
{
    public function __construct(
        private ClockRecordServiceInterface $clockRecordService
    ) {}

    public function register(Request $request): JsonResponse
    {
        try {
            $record = $this->clockRecordService->register($request->user()->id);

            return response()->json([
                'message' => 'Ponto registrado com sucesso!',
                'data' => $record,
            ], HttpStatus::CREATED);

        } catch (\Throwable $e) {
            throw new ApiException('Erro ao registrar ponto.', HttpStatus::INTERNAL_SERVER_ERROR);
        }
    }

    public function report(Request $request): JsonResponse
    {
        try {
            $rawData = $this->clockRecordService->generateReport(
                $request->input('start'),
                $request->input('end')
            );

            $collection = collect($rawData);

            if ($collection->isEmpty()) {
                throw new ApiException(statusCode: HttpStatus::NO_CONTENT);
            }

            return response()->json(
                ClockRecordReportResource::collection($collection),
                HttpStatus::OK
            );

        } catch (\InvalidArgumentException $e) {
            throw new ApiException($e->getMessage(), HttpStatus::BAD_REQUEST);

        } catch (\Throwable $e) {
            throw new ApiException('Erro ao gerar o relatório.', HttpStatus::INTERNAL_SERVER_ERROR);
        }
    }
}
