<?php

declare(strict_types=1);

namespace App\Modules\Post\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessagesResource;
use App\Modules\Post\Contracts\Services\PostService;
use App\Modules\Post\Contracts\Swagger\PostSwagger;
use App\Modules\Post\Requests\PostsListRequest;
use App\Modules\Post\Requests\StorePostRequest;
use App\Modules\Post\Requests\UpdatePostRequest;
use App\Modules\Post\Resources\PostResource;
use App\Modules\Post\Resources\PostsResource;

final class PostController extends Controller implements PostSwagger
{
    public function __construct(private readonly PostService $service)
    {
    }

    public function index(PostsListRequest $request): PostsResource
    {
        return new PostsResource(
            $this->service->findAll($request->getDTO())
        );
    }

    public function show(int $id): PostResource
    {
        return new PostResource(
            $this->service->findById($id)
        );
    }

    public function store(StorePostRequest $request): PostResource
    {
        return new PostResource(
            $this->service->create($request->getDTO())
        );
    }

    public function update(int $id, UpdatePostRequest $request): PostResource
    {
        return new PostResource(
            $this->service->update($id, $request->getDTO())
        );
    }

    public function destroy(int $id): MessagesResource
    {
        $this->service->delete($id);

        return (new MessagesResource(null))
            ->setMessage('Post deleted');
    }
}
