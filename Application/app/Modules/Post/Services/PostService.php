<?php

declare(strict_types=1);

namespace App\Modules\Post\Services;

use App\Modules\Post\Contracts\Services\PostService as PostServiceContract;
use App\Modules\Post\DTOs\PostsListDTO;
use App\Modules\Post\DTOs\StorePostDTO;
use App\Modules\Post\Enums\Status;
use App\Modules\Post\Helpers\AudioHelper;
use App\Modules\Post\Models\Post;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Audio\Mp3;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostService implements PostServiceContract
{
    public function findAll(PostsListDTO $dto): LengthAwarePaginator
    {
        return Post::query()
            ->when($dto->sort, fn(Builder $query) => $query->orderBy('created_at', $dto->sort))
            ->when($dto->title, fn(Builder $query) => $query->where('title', 'like', '%' . $dto->title . '%'))
            ->when($dto->statusIds, fn(Builder $query) => $query->whereIn('status', $dto->statusIds))
            ->paginate($dto->limit, ['*'], 'page', $dto->page);
    }

    public function findById(int $id): Post
    {
        /** @var Post */
        return Post::query()->findOrFail($id);
    }

    public function create(StorePostDTO $dto): bool
    {
        try {
            DB::transaction(static function () use ($dto) {
                $compressedFilePath = AudioHelper::compress($dto->audio);

                $storedPath = Storage::putFile(Post::FOLDER_NAME, new File($compressedFilePath));

                /** @var Post $post */
                $post = Post::query()
                    ->create([
                        'user_id'            => (int)Auth::id(),
                        'title'              => $dto->title,
                        'description'        => $dto->description,
                        'status'             => Status::ACTIVE,
                        'file_path'          => $storedPath,
                        'file_original_name' => $dto->audio->getClientOriginalName(),
                    ]);

                foreach ($dto->tagIds as $tagId) {
                    $post->tags()->attach($tagId);
                }
            });

            return true;
        } catch (\Exception $exception) {
            throw new \DomainException($exception->getMessage());
        }
    }
}
