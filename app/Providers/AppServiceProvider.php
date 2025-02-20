<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Domain\Services\AuthServiceInterface;
use App\Domain\Repositories\SuperAdminRepositoryInterface;

use App\Infrastructure\Repositories\SuperAdminRepository;

use App\Application\Services\AuthService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SuperAdminRepositoryInterface::class, SuperAdminRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
