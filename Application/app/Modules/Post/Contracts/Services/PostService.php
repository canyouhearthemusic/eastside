<?php

declare(strict_types=1);

namespace App\Modules\Post\Contracts\Services;

use App\Modules\Post\DTOs\PostsListDTO;
use App\Modules\Post\DTOs\StorePostDTO;
use App\Modules\Post\DTOs\UpdatePostDTO;
use App\Modules\Post\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface PostService
{
    public function findAll(PostsListDTO $dto): LengthAwarePaginator;

    public function findById(int $id): Post;

    public function create(StorePostDTO $dto): Post;

    public function update(int $id, UpdatePostDTO $dto): Post;

    public function delete(int $id): bool;
}
