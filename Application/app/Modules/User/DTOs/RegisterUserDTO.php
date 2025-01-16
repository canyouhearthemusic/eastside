<?php

namespace App\Modules\User\DTOs;

use App\Modules\User\Requests\RegisterUserRequest;

final readonly class RegisterUserDTO
{
    public string $name;
    public string $email;
    public string $password;

    public static function fromRequest(RegisterUserRequest $request): self
    {
        $dto           = new self();
        $dto->name     = $request->get('name');
        $dto->email    = $request->get('email');
        $dto->password = $request->get('password');

        return $dto;
    }
}
