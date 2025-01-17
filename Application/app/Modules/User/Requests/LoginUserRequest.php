<?php

declare(strict_types=1);

namespace App\Modules\User\Requests;

use App\Modules\User\DTOs\LoginUserDTO;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="LoginUserRequest",
 *     type="object",
 *     required={"email", "password"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="The email address of the user.",
 *         maxLength=255,
 *         example="user@example.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="The password of the user. Must be at least 8 characters.",
 *         minLength=8
 *     )
 * )
 */
final class LoginUserRequest extends FormRequest
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
            'email'    => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8'],
        ];
    }

    public function getDTO(): LoginUserDTO
    {
        return LoginUserDTO::fromRequest($this);
    }
}
