<?php

namespace App\Modules\User\Providers;

use App\Modules\User\Contracts\Services\AuthService as AuthServiceContract;
use App\Modules\User\Services\AuthService;
use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    public array $bindings = [
        AuthServiceContract::class => AuthService::class,
    ];
}