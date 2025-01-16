<?php

declare(strict_types=1);

namespace App\Modules\Post\Services;

use App\Modules\Post\Contracts\Services\PostService as PostServiceContract;
use App\Modules\Post\DTOs\PostsListDTO;
use App\Modules\Post\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class PostService implements PostServiceContract
{
    public function findAll(PostsListDTO $dto): LengthAwarePaginator
    {
        return Post::query()
            ->when($dto->sort, fn (Builder $query) => $query->orderBy('created_at', $dto->sort))
            ->when($dto->title, fn (Builder $query) => $query->where('title', 'like', '%' . $dto->title . '%'))
            ->when($dto->statusIds, fn (Builder $query) => $query->whereIn('status', $dto->statusIds))
            ->paginate($dto->limit, ['*'], 'page', $dto->page);
    }
}
