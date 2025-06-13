<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\JsonResponse;
use App\Enums\HttpStatus;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception): JsonResponse
    {
        // Se for uma ApiException, usa nosso render personalizado
        if ($exception instanceof ApiException) {
            return $exception->render();
        }

        // Captura erros padrão do Laravel e converte para nossa resposta personalizada
        $statusCode = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : HttpStatus::INTERNAL_SERVER_ERROR;
        
        $message = ApiException::getDefaultMessage($statusCode);

        return response()->json([
            'error' => $message,
            'status' => $statusCode
        ], $statusCode);
    }
}
