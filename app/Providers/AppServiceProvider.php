<?php

namespace App\Providers;

use App\Services\impl\QuizServiceImpl;
use App\Services\impl\UserServiceImpl;
use App\Services\impl\AuthServiceImpl;
use App\Services\QuizService;
use App\Services\UserService;
use App\Services\AuthService;
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
        $this->app->bind(QuizService::class, QuizServiceImpl::class);
        $this->app->bind(UserService::class, UserServiceImpl::class);
        $this->app->bind(AuthService::class, AuthServiceImpl::class);
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
