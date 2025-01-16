<?php

namespace App\Modules\Post\DTOs;

use App\Modules\Post\Requests\PostsListRequest;

final class PostsListDTO
{
    public string $sort;
    public int $limit;
    public int $page;
    public ?string $title;
    public ?array $statusIds;
    public ?array $tagIds;

    public static function fromRequest(PostsListRequest $request): self
    {
        $dto            = new self();
        $dto->sort      = $request->get('sort', 'desc');
        $dto->limit     = $request->get('limit', 20);
        $dto->page      = $request->get('page', 1);
        $dto->title     = $request->get('title') ?: null;
        $dto->statusIds = $request->get('statusIds') ?: null;
        $dto->tagIds    = $request->get('tagIds') ?: null;

        return $dto;
    }
}
