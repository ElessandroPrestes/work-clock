<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\EmployeeServiceInterface;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFuncionarioRequest;
use App\Http\Resources\FuncionarioResource;
use Illuminate\Http\JsonResponse;
use App\Enums\HttpStatus;

class FuncionarioController extends Controller
{
    public function __construct(
        private EmployeeServiceInterface $funcionarioService
    ) {}

   
    public function index(): JsonResponse
    {
        return response()->json(FuncionarioResource::collection(
            $this->funcionarioService->listar()
        ), HttpStatus::OK);
    }

    
    public function show(int $id): JsonResponse
    {
        return response()->json(new FuncionarioResource(
            $this->funcionarioService->obterPorId($id)
        ), HttpStatus::OK);
    }

   
    public function store(StoreFuncionarioRequest $request): JsonResponse
    {
        return response()->json(new FuncionarioResource(
            $this->funcionarioService->cadastrar($request->validated())
        ), HttpStatus::CREATED);
    }

    
    public function update(StoreFuncionarioRequest $request, int $id): JsonResponse
    {
        $funcionario = $this->funcionarioService->obterPorId($id);
        return response()->json(new FuncionarioResource(
            $this->funcionarioService->atualizar($funcionario, $request->validated())
        ), HttpStatus::OK);
    }

   
    public function destroy(int $id): JsonResponse
    {
        $funcionario = $this->funcionarioService->obterPorId($id);
        $this->funcionarioService->deletar($funcionario);

        return response()->json(null, HttpStatus::NO_CONTENT);
    }
}
