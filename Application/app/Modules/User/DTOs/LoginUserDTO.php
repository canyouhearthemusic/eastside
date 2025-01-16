<?php

declare(strict_types=1);

namespace App\Modules\User\DTOs;

use App\Modules\User\Requests\LoginUserRequest;

final readonly class LoginUserDTO
{
    public string $email;
    public string $password;

    public static function fromRequest(LoginUserRequest $request): self
    {
        $dto           = new self();
        $dto->email    = $request->get('email');
        $dto->password = $request->get('password');

        return $dto;
    }
}
