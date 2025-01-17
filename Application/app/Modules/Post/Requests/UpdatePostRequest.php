<?php

declare(strict_types=1);

namespace App\Modules\Post\Requests;

use App\Modules\Post\DTOs\UpdatePostDTO;
use App\Modules\Post\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     description="Request for updating an existing post",
 *     type="object",
 *     required={"tagIds", "title", "description"},
 *     @OA\Property(
 *         property="statusId",
 *         description="Status of the post (optional, valid values are from Status enum)",
 *         type="integer",
 *         example=Status::ACTIVE
 *     ),
 *     @OA\Property(
 *         property="tagIds",
 *         description="Array of tag IDs associated with the post",
 *         type="array",
 *         @OA\Items(
 *             type="integer",
 *             example=1
 *         )
 *     ),
 *     @OA\Property(
 *         property="title",
 *         description="Title of the post",
 *         type="string",
 *         example="Updated Post Title"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         description="Description of the post",
 *         type="string",
 *         example="This is an updated description of the post"
 *     ),
 *     @OA\Property(
 *         property="audio",
 *         description="Audio file associated with the post (optional)",
 *         type="string",
 *         format="binary"
 *     )
 * )
 */
class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'statusId'    => ['nullable', 'in:' . implode(',', Status::values())],
            'tagIds'      => ['required', 'array'],
            'tagIds.*'    => ['required', 'integer', 'exists:tags,id'],
            'title'       => ['required', 'string'],
            'description' => ['required', 'string'],
            'audio'       => ['nullable', 'mimetypes:audio/mpeg', 'max:2048'],
        ];
    }

    public function getDTO(): UpdatePostDTO
    {
        return UpdatePostDTO::fromRequest($this);
    }
}
