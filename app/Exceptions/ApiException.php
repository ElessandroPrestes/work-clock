<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use App\Enums\HttpStatus;

class ApiException extends Exception
{
    protected int $statusCode;

    private static array $messages = [
        // Sucesso (2xx)
        HttpStatus::OK => "Operação realizada com sucesso.",
        HttpStatus::CREATED => "Recurso criado com sucesso.",
        HttpStatus::ACCEPTED => "Requisição aceita para processamento.",
        HttpStatus::NO_CONTENT => "Operação realizada, sem conteúdo na resposta.",

        // Erros do Cliente (4xx)
        HttpStatus::BAD_REQUEST => "Dados inválidos. Verifique e tente novamente.",
        HttpStatus::UNAUTHORIZED => "Você não tem permissão para acessar este recurso.",
        HttpStatus::FORBIDDEN => "Ação não permitida.",
        HttpStatus::NOT_FOUND => "O recurso solicitado não foi encontrado.",
        HttpStatus::METHOD_NOT_ALLOWED => "Método HTTP não permitido para este recurso.",
        HttpStatus::CONFLICT => "Conflito na requisição. Verifique os dados enviados.",

        // Erros do Servidor (5xx)
        HttpStatus::INTERNAL_SERVER_ERROR => "Erro interno no servidor. Tente novamente mais tarde.",
        HttpStatus::NOT_IMPLEMENTED => "Essa funcionalidade ainda não está disponível.",
        HttpStatus::BAD_GATEWAY => "Erro na comunicação entre servidores. Tente novamente.",
        HttpStatus::SERVICE_UNAVAILABLE => "Serviço temporariamente indisponível. Tente mais tarde.",
        HttpStatus::GATEWAY_TIMEOUT => "Tempo limite excedido ao tentar acessar outro serviço.",
    ];

    public function __construct(string $message = '', int $statusCode = HttpStatus::BAD_REQUEST)
    {
        parent::__construct($message ?: self::$messages[$statusCode] ?? "Erro desconhecido.");
        $this->statusCode = $statusCode;
    }

    public function render(): JsonResponse
    {
        return response()->json([
            'error' => $this->getMessage(),
            'status' => $this->statusCode
        ], $this->statusCode);
    }

    public static function getDefaultMessage(int $statusCode): string
    {
        return self::$messages[$statusCode] ?? "Erro desconhecido.";
    }

}
