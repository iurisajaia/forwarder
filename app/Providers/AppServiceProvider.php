<?php

namespace App\Providers;

use App\Repositories\CarRepository;
use App\Repositories\CarTypeRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Repositories\Interfaces\CarRepositoryInterface;
use App\Repositories\Interfaces\CarTypeRepositoryInterface;
use App\Repositories\Interfaces\TrailerRepositoryInterface;
use App\Repositories\Interfaces\TrailerTypeRepositoryInterface;
use App\Repositories\Interfaces\UserTypeRepositoryInterface;
use App\Repositories\TrailerRepository;
use App\Repositories\TrailerTypeRepository;
use App\Repositories\UserTypeRepository;
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
        $this->app->bind(CarRepositoryInterface::class , CarRepository::class);
        $this->app->bind(TrailerRepositoryInterface::class , TrailerRepository::class);
        $this->app->bind(UserTypeRepositoryInterface::class , UserTypeRepository::class);
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
