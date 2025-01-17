<?php

declare(strict_types=1);

namespace App\Modules\User\Requests;

use App\Modules\User\DTOs\RegisterUserDTO;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="RegisterUserRequest",
 *     type="object",
 *     required={"name", "email", "password"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="The name of the user.",
 *         maxLength=50
 *     ),
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
 *         description="The password of the user. Must be at least 8 characters and confirmed.",
 *         minLength=8
 *     ),
 *     @OA\Property(
 *         property="password_confirmation",
 *         type="string",
 *         description="The confirmation of the user's password."
 *     )
 * )
 */
final class RegisterUserRequest extends FormRequest
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
            'name'     => ['required', 'string', 'max:50'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function getDTO(): RegisterUserDTO
    {
        return RegisterUserDTO::fromRequest($this);
    }
}
