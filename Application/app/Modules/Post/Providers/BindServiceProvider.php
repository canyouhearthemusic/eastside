<?php

namespace App\Modules\Post\Providers;

use App\Modules\Post\Contracts\Services\PostService as PostServiceContract;
use App\Modules\Post\Services\PostService;
use Illuminate\Support\ServiceProvider;

final class BindServiceProvider extends ServiceProvider
{
    public array $bindings = [
        PostServiceContract::class => PostService::class,
    ];
}
