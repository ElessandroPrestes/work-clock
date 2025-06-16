<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Services\EmployeeServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Enums\HttpStatus;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function __construct(
        private UserServiceInterface $userService
    ) {}

   
    public function index(): JsonResponse
    {
        $employees = $this->userService->listSubordinates(auth()->id());

        return response()->json(UserResource::collection($employees), HttpStatus::OK);
    }

    
    public function show(int $id): JsonResponse
    {
        $employee = $this->userService->getById($id);

        return response()->json(new UserResource($employee), HttpStatus::OK);
    }

   
    public function store(StoreUserRequest $request): JsonResponse
    {
        $employee = $this->userService->store($request->validated(), auth()->id());

        return response()->json(new UserResource($employee), HttpStatus::CREATED);
    }

    
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
       $user = $this->userService->getById($id); 
        $this->userService->update($user, $request->validated());

        return response()->json(['message' => 'Usuário Atualizado!'], HttpStatus::OK);
    }

   
    public function destroy(int $id): JsonResponse
    {
        $user = $this->userService->getById($id); 
        $this->userService->delete($user);

        return response()->json(null, HttpStatus::NO_CONTENT);
    }
}
