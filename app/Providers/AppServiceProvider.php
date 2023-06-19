<?php

namespace App\Providers;

use App\Repositories\CarTypeRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Repositories\Interfaces\CarTypeRepositoryInterface;
use App\Repositories\Interfaces\TrailerTypeRepositoryInterface;
use App\Repositories\TrailerTypeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AuthRepositoryInterface::class , AuthRepository::class);
        $this->app->bind(CarTypeRepositoryInterface::class , CarTypeRepository::class);
        $this->app->bind(TrailerTypeRepositoryInterface::class , TrailerTypeRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
