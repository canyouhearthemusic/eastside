<?php

declare(strict_types=1);

namespace App\Modules\User\Resources;

use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="User resource representation",
 *     type="object",
 *     required={"id", "name", "email"},
 *     @OA\Property(
 *         property="id",
 *         description="ID of the user",
 *         type="integer",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="name",
 *         description="Name of the user",
 *         type="string",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         description="Email address of the user",
 *         type="string",
 *         format="email",
 *         example="john.doe@example.com"
 *     )
 * )
 * @property User $resource
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->resource->id,
            'name'  => $this->resource->name,
            'email' => $this->resource->email,
        ];
    }
}