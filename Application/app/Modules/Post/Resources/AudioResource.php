<?php

namespace App\Modules\Post\Resources;

use App\Modules\Post\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Audio resource representation",
 *     type="object",
 *     @OA\Property(
 *         property="path",
 *         description="File path",
 *         type="string",
 *         example="http://localhost/api/audio/play/posts/ItX1CvUUaxzOuPcpStNchtuhDRLKROl8hds2XW4N.mp3"
 *     ),
 *     @OA\Property(
 *         property="originalName",
 *         description="Original name of the file",
 *         type="string",
 *         example="audio.mp3"
 *     )
 * )
 * @property Post $resource
 */
class AudioResource extends JsonResource
{
    public function toArray(Request $request): ?array
    {
        $data = [];

        if ($this->resource->file_path) {
            $data = [
                'path'         => route('audio.play', $this->resource->file_path),
                'originalName' => $this->resource?->file_original_name,
            ];
        }

        return $data;
    }
}
