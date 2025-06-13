<?php

namespace App\Providers;

use App\Contracts\Repositories\AddressRepositoryInterface;
use App\Contracts\Repositories\ClockRecordRepositoryInterface;
use App\Contracts\Repositories\EmployeeRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\AddressServiceInterface;
use App\Contracts\Services\ClockRecordServiceInterface;
use App\Contracts\Services\EmployeeServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Repositories\AddressRepository;
use App\Repositories\ClockRecordRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\UserRepository;
use App\Services\AddressService;
use App\Services\ClockRecordService;
use App\Services\EmployeeService;
use App\Services\UserService;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $bindings = [
            AddressServiceInterface::class => AddressService::class,
            UserServiceInterface::class => UserService::class,
            ClockRecordServiceInterface::class => ClockRecordService::class,
            EmployeeServiceInterface::class => EmployeeService::class,
            AddressRepositoryInterface::class => AddressRepository::class,
            UserRepositoryInterface::class => UserRepository::class,
            ClockRecordRepositoryInterface::class => ClockRecordRepository::class,
            EmployeeRepositoryInterface::class => EmployeeRepository::class,
        ];

        foreach ($bindings as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
