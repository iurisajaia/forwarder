<?php

namespace App\Providers;

use App\Repositories\CarRepository;
use App\Repositories\CarTypeRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\CarRepositoryInterface;
use App\Repositories\Interfaces\CarTypeRepositoryInterface;
use App\Repositories\Interfaces\TrailerRepositoryInterface;
use App\Repositories\Interfaces\TrailerTypeRepositoryInterface;
use App\Repositories\TrailerRepository;
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
        $this->app->bind(UserRepositoryInterface::class , UserRepository::class);
        $this->app->bind(CarTypeRepositoryInterface::class , CarTypeRepository::class);
        $this->app->bind(TrailerTypeRepositoryInterface::class , TrailerTypeRepository::class);
        $this->app->bind(CarRepositoryInterface::class , CarRepository::class);
        $this->app->bind(TrailerRepositoryInterface::class , TrailerRepository::class);
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
