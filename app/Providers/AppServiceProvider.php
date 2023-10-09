<?php

namespace App\Providers;

use App\Repositories\CarRepository;
use App\Repositories\CargoRepository;
use App\Repositories\CarTypeRepository;
use App\Repositories\ChatRepository;
use App\Repositories\DealRepository;
use App\Repositories\Interfaces\CargoRepositoryInterface;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use App\Repositories\Interfaces\DealRepositoryInterface;
use App\Repositories\Interfaces\NotificationRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\NotificationRepository;
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
        $this->app->bind(ChatRepositoryInterface::class , ChatRepository::class);
        $this->app->bind(DealRepositoryInterface::class , DealRepository::class);
        $this->app->bind(CargoRepositoryInterface::class , CargoRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class , NotificationRepository::class);

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
