<?php


namespace App\Http\Controllers\Api;

use App\Contracts\Services\ClockRecordServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class ClockRecordController extends Controller
{
    public function __construct(
        private ClockRecordServiceInterface $clockRecordService
    ) {}

    public function registrar(Request $request): JsonResponse
    {
        $record = $this->clockRecordService->registrar($request->user()->id);

        return response()->json([
            'message' => 'Ponto registrado com sucesso!',
            'data' => $record,
        ], 201);
    }

    public function relatorio(Request $request): JsonResponse
    {
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date|after_or_equal:start',
        ]);

        $start = $request->input('start');
        $end = $request->input('end');

        $result = $this->clockRecordService->gerarRelatorio(
            $request->input('start'),
            $request->input('end')
        );

        return response()->json($result);
    }
}
