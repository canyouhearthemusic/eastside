<?php

declare(strict_types=1);

namespace App\Modules\Post\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Post\Contracts\Services\PostService;
use App\Modules\Post\Requests\PostsListRequest;
use Illuminate\Pagination\LengthAwarePaginator;

final class PostController extends Controller
{
    public function __construct(private readonly PostService $service)
    {
    }

    public function index(PostsListRequest $request): LengthAwarePaginator
    {
        return $this->service->findAll($request->getDTO());
    }
}
