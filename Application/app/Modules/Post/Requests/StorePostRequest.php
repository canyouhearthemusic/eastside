<?php

namespace App\Modules\Post\Requests;

use App\Modules\Post\DTOs\StorePostDTO;
use Illuminate\Foundation\Http\FormRequest;

final class StorePostRequest extends FormRequest
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
            'tagIds'      => ['required', 'array'],
            'tagIds.*'    => ['required', 'integer', 'exists:tags,id'],
            'title'       => ['required', 'string'],
            'description' => ['required', 'string'],
            'audio'       => ['nullable', 'mimetypes:audio/mpeg', 'max:2048'],
        ];
    }

    public function getDTO(): StorePostDTO
    {
        return StorePostDTO::fromRequest($this);
    }
}
