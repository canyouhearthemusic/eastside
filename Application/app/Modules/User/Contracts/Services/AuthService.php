<?php

declare(strict_types=1);

namespace App\Modules\User\Contracts\Services;

use App\Modules\User\DTOs\LoginUserDTO;
use App\Modules\User\DTOs\RegisterUserDTO;

interface AuthService
{
    public function register(RegisterUserDTO $DTO);

    public function login(LoginUserDTO $DTO);
}
