<?php

namespace App\Modules\Post\Requests;

use App\Modules\Post\DTOs\PostsListDTO;
use App\Modules\Post\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;

final class PostsListRequest extends FormRequest
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
            'sort'        => ['nullable', 'string', 'in:asc,desc'],
            'limit'       => ['nullable', 'integer', 'min:5'],
            'page'        => ['nullable', 'integer', 'min:1'],
            'title'       => ['nullable', 'string'],
            'statusIds'   => ['nullable', 'array'],
            'statusIds.*' => ['integer', 'in:' . implode(',', Status::values())],
            'tagIds'      => ['nullable', 'array'],
            'tagIds.*'    => ['integer', 'exists:tags,id'],
        ];
    }

    public function getDTO(): PostsListDTO
    {
        return PostsListDTO::fromRequest($this);
    }
}
