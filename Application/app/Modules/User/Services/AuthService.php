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

    public function register(RegisterUserDTO $DTO): string
    {
        $user = User::query()->create([
            'name'     => $DTO->name,
            'email'    => $DTO->email,
            'password' => $DTO->password,
        ]);

        return $this->jwtAuth->fromUser($user);
    }

    public function login(LoginUserDTO $DTO): string
    {
        $credentials = [
            'email'    => $DTO->email,
            'password' => $DTO->password,
        ];

        if (!$token = $this->jwtAuth->attempt($credentials)) {
            throw new \DomainException('Invalid credentials');
        }

        return $token;
    }
}
