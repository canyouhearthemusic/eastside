<?php

namespace App\Modules\Post\Resources;

use App\Modules\Post\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Tag resource representation",
 *     type="object",
 *     required={"id", "name"},
 *     @OA\Property(
 *         property="id",
 *         description="ID of the tag",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         description="Name of the tag",
 *         type="string",
 *         example="Technology"
 *     )
 * )
 * @property Tag $resource
 */
class TagResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'   => $this->resource->id,
            'name' => $this->resource->name,
        ];
    }
}
