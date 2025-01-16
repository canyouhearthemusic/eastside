<?php

declare(strict_types=1);

namespace App\Modules\User\Services;

use App\Modules\User\Contracts\Services\AuthService as AuthServiceContract;
use App\Modules\User\DTOs\LoginUserDTO;
use App\Modules\User\DTOs\RegisterUserDTO;
use App\Modules\User\Models\User;
use Tymon\JWTAuth\JWTAuth;

final readonly class AuthService implements AuthServiceContract
{
    public function __construct(private JWTAuth $jwtAuth)
    {
    }

    public function register(RegisterUserDTO $dto): string
    {
        $user = User::query()->create([
            'name'     => $dto->name,
            'email'    => $dto->email,
            'password' => $dto->password,
        ]);

        return $this->jwtAuth->fromUser($user);
    }

    public function login(LoginUserDTO $dto): string
    {
        $credentials = [
            'email'    => $dto->email,
            'password' => $dto->password,
        ];

        if (!$token = $this->jwtAuth->attempt($credentials)) {
            throw new \DomainException('Invalid credentials');
        }

        return $token;
    }
}
