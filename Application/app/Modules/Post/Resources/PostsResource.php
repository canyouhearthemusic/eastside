<?php

declare(strict_types=1);

namespace App\Modules\Post\Resources;

use App\Http\Resources\BaseResourceCollection;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/PostResource")
 *     )
 * )
 */
class PostsResource extends BaseResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'data' => PostResource::collection($this->collection),
        ];
    }
}
