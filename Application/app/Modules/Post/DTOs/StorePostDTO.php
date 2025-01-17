<?php

declare(strict_types=1);

namespace App\Modules\Post\DTOs;

use App\Modules\Post\Requests\StorePostRequest;
use Illuminate\Http\UploadedFile;

final class StorePostDTO
{
    public array $tagIds;
    public string $title;
    public string $description;
    public ?UploadedFile $audio;

    public static function fromRequest(StorePostRequest $request): self
    {
        $dto              = new self();
        $dto->tagIds      = $request->get('tagIds');
        $dto->title       = $request->get('title');
        $dto->description = $request->get('description');
        $dto->audio       = $request->file('audio') ?: null;

        return $dto;
    }
}
