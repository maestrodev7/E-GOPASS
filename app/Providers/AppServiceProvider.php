<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Domain\Services\AuthServiceInterface;
use App\Domain\Services\AdminServiceInterface;
use App\Domain\Services\AgentServiceInterface;

use App\Domain\Repositories\SuperAdminRepositoryInterface;
use App\Domain\Repositories\AdminRepositoryInterface;
use App\Domain\Repositories\AgentRepositoryInterface;

use App\Infrastructure\Repositories\SuperAdminRepository;
use App\Infrastructure\Repositories\AdminRepository;
use App\Infrastructure\Repositories\AgentRepository;

use App\Application\Services\AuthService;
use App\Application\Services\AdminService;
use App\Application\Services\AgentService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SuperAdminRepositoryInterface::class, SuperAdminRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(AgentRepositoryInterface::class, AgentRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(AdminServiceInterface::class, AdminService::class);
        $this->app->bind(AgentServiceInterface::class, AgentService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
