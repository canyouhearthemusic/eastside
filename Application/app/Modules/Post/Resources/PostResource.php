<?php

declare(strict_types=1);

namespace App\Modules\Post\Resources;

use App\Http\Resources\BaseJsonResource;
use App\Modules\Post\Models\Post;
use App\Modules\User\Resources\UserResource;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Post resource representation",
 *     type="object",
 *     required={"id", "title", "description", "status", "audio", "createdAt", "updatedAt"},
 *     @OA\Property(
 *         property="id",
 *         description="ID of the post",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="title",
 *         description="Title of the post",
 *         type="string",
 *         example="My Post Title"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         description="Description of the post",
 *         type="string",
 *         example="This is a detailed description of the post."
 *     ),
 *     @OA\Property(
 *         property="user",
 *         description="The user associated with the post",
 *         type="object",
 *         ref="#/components/schemas/UserResource"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="object",
 *         ref="#/components/schemas/StatusResource"
 *     ),
 *     @OA\Property(
 *         property="tags",
 *         description="Tags associated with the post",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/TagResource"),
 *     ),
 *     @OA\Property(
 *         property="audio",
 *         description="Audio file details",
 *         type="object",
 *         @OA\Property(
 *             property="path",
 *             description="Path to the audio file",
 *             type="string",
 *             example="/storage/posts/audiofile.mp3"
 *         ),
 *         @OA\Property(
 *             property="originalName",
 *             description="Original file name",
 *             type="string",
 *             example="audiofile.mp3"
 *         )
 *     ),
 *     @OA\Property(
 *         property="createdAt",
 *         description="Creation date of the post",
 *         type="string",
 *         format="date-time",
 *         example="2025-01-17"
 *     ),
 *     @OA\Property(
 *         property="updatedAt",
 *         description="Last update date of the post",
 *         type="string",
 *         format="date-time",
 *         example="2025-01-17"
 *     )
 * )
 * @property Post $resource
 */
class PostResource extends BaseJsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->resource->id,
            'title'       => $this->resource->title,
            'description' => $this->resource->description,
            'user'        => new UserResource($this->resource->user),
            'status'      => $this->resource->status?->label(),
            'tags'        => TagResource::collection($this->resource->tags),
            'audio'       => new AudioResource($this->resource),
            'createdAt'   => $this->resource->created_at->toDateTimeString(),
            'updatedAt'   => $this->resource->updated_at->toDateTimeString(),
        ];
    }
}