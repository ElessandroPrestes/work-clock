<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\AddressServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Enums\HttpStatus;
use App\Exceptions\ApiException;
use App\Models\User;
use Illuminate\Support\Collection;

class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private AddressServiceInterface $addressService
    ) {}

    public function create(array $data, ?int $managerId = null): User
    {
        $data['manager_id'] = $managerId;
        $data['password'] = bcrypt($data['password']);

        $user = $this->repository->create($data);

        $this->addressService->saveAddress($user->id, $data['zip_code']);

        return $user;
    }

    public function update(User $user, array $data): bool
    {
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $this->addressService->saveAddress($user->id, $data['zip_code']);

        return $this->repository->update($user, $data);
    }

    public function delete(User $user): bool
    {
        return $this->repository->delete($user);
    }

    public function getAll(): Collection
    {
        return $this->repository->getAll();
    }

   public function getById(int $id): ?User
    {
        $user = $this->repository->getById($id);
        if (!$user) {
            throw new ApiException("User not found", HttpStatus::NOT_FOUND);
        }
        return $user;
    }

    public function getSubordinates(int $managerId): Collection
    {
        return $this->repository->allByManager($managerId);
    }

}
