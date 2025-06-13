<?php

namespace App\Providers;

use App\Contracts\Repositories\AddressRepositoryInterface;
use App\Contracts\Repositories\ClockRecordRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Contracts\Services\AddressServiceInterface;
use App\Contracts\Services\ClockRecordServiceInterface;
use App\Contracts\Services\UserServiceInterface;
use App\Repositories\AddressRepository;
use App\Repositories\ClockRecordRepository;
use App\Repositories\UserRepository;
use App\Services\AddressService;
use App\Services\ClockRecordService;
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
        $this->app->bind(
        UserRepositoryInterface::class,
        UserRepository::class
        );

        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );

        $this->app->bind(
            ClockRecordRepositoryInterface::class,
            ClockRecordRepository::class
        );

        $this->app->bind(
            ClockRecordServiceInterface::class,
            ClockRecordService::class
        );

        $this->app->bind(
            AddressRepositoryInterface::class,
            AddressRepository::class
        );

        $this->app->bind(
            AddressServiceInterface::class,
            AddressService::class
        );

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
