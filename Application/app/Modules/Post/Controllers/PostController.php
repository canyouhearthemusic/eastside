<?php

declare(strict_types=1);

namespace App\Modules\Post\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Post\Contracts\Services\PostService;
use App\Modules\Post\Models\Post;
use App\Modules\Post\Requests\PostsListRequest;
use App\Modules\Post\Requests\StorePostRequest;
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

    public function show(int $id): Post
    {
        return $this->service->findById($id);
    }

    public function store(StorePostRequest $request): Post
    {
        return $this->service->create($request->getDTO());
    }
}
