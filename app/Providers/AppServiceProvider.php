<?php

namespace App\Providers;

use App\Factories\ModelFactory;
use App\Interfaces\ModelFactoryInterface;
use App\Interfaces\RepositoryInterface;
use App\Repositories\AdminRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ModelFactoryInterface::class, ModelFactory::class);
        $this->app->bind(RepositoryInterface::class, AdminRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
