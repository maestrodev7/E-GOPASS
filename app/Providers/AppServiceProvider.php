<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Domain\Services\AuthServiceInterface;
use App\Domain\Services\AdminServiceInterface;
use App\Domain\Repositories\SuperAdminRepositoryInterface;
use App\Domain\Repositories\AdminRepositoryInterface;

use App\Infrastructure\Repositories\SuperAdminRepository;
use App\Infrastructure\Repositories\AdminRepository;

use App\Application\Services\AuthService;
use App\Application\Services\AdminService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SuperAdminRepositoryInterface::class, SuperAdminRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(AdminServiceInterface::class, AdminService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
