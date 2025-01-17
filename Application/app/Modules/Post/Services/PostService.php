<?php

declare(strict_types=1);

namespace App\Modules\Post\Services;

use App\Modules\Post\Contracts\Services\PostService as PostServiceContract;
use App\Modules\Post\DTOs\PostsListDTO;
use App\Modules\Post\DTOs\StorePostDTO;
use App\Modules\Post\DTOs\UpdatePostDTO;
use App\Modules\Post\Enums\Status;
use App\Modules\Post\Helpers\AudioHelper;
use App\Modules\Post\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

final readonly class PostService implements PostServiceContract
{
    public function __construct(private AudioHelper $audioHelper)
    {
    }

    public function findAll(PostsListDTO $dto): LengthAwarePaginator
    {
        return Post::query()
            ->when($dto->sort, fn(Builder $query) => $query->orderBy('created_at', $dto->sort))
            ->when($dto->title, fn(Builder $query) => $query->where('title', 'like', '%' . $dto->title . '%'))
            ->when($dto->statusIds, fn(Builder $query) => $query->whereIn('status', $dto->statusIds))
            ->paginate($dto->limit, ['*'], 'page', $dto->page)
            ->withQueryString();
    }

    public function findById(int $id): Post
    {
        /** @var Post */
        return Post::query()->findOrFail($id);
    }

    public function create(StorePostDTO $dto): Post
    {
        return DB::transaction(function () use ($dto) {
            $storedPath = $this->handleAudioUpload($dto->audio);

            /** @var Post $post */
            $post = Post::query()->create([
                'user_id'            => (int)Auth::id(),
                'title'              => $dto->title,
                'description'        => $dto->description,
                'status'             => Status::ACTIVE,
                'file_path'          => $storedPath,
                'file_original_name' => $dto->audio?->getClientOriginalName(),
            ]);

            $post->tags()->attach($dto->tagIds);

            return $post;
        });
    }

    public function update(int $id, UpdatePostDTO $dto): Post
    {
        return DB::transaction(function () use ($id, $dto) {
            $storedPath = $this->handleAudioUpload($dto->audio);

            /** @var Post $post */
            $post = Post::query()->findOrFail($id);
            $post->update([
                'title'              => $dto->title ?: $post->title,
                'description'        => $dto->description ?: $post->description,
                'status'             => $dto->status ?: $post->status,
                'file_path'          => $storedPath ?: $post->file_path,
                'file_original_name' => $dto->audio?->getClientOriginalName() ?: $post->file_original_name,
            ]);

            $post->tags()->sync($dto->tagIds);

            return $post->fresh();
        });
    }

    public function delete(int $id): bool
    {
        $post = Post::query()->findOrFail($id);
        return $post->delete();
    }

    private function handleAudioUpload(?UploadedFile $audio): ?string
    {
        if ($audio === null) {
            return null;
        }

        $compressedFilePath = $this->audioHelper->compress($audio);
        $storedPath         = Storage::putFile(Post::FOLDER_NAME, new File($compressedFilePath));
        $this->audioHelper->cleanup($compressedFilePath);

        return $storedPath;
    }
}
