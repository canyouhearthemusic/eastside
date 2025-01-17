<?php

declare(strict_types=1);

namespace App\Modules\Post\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/TagResource")
 *     )
 * )
 */
class TagsResource extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => TagResource::collection($this->collection),
        ];
    }
}
