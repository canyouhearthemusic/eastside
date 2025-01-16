<?php

namespace App\Modules\User\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\User\Contracts\Services\AuthService;
use App\Modules\User\Requests\LoginUserRequest;
use App\Modules\User\Requests\RegisterUserRequest;
use Illuminate\Http\JsonResponse;

final class AuthController extends Controller
{
    public function __construct(private readonly AuthService $service)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $token = $this->service->register($request->getDTO());

        return $this->respondWithToken($token);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $token = $this->service->login($request->getDTO());

        return $this->respondWithToken($token);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(): JsonResponse
    {
        $newToken = auth()->refresh();

        return $this->respondWithToken($newToken);
    }

    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'accessToken' => $token,
            'tokenType'   => 'Bearer',
            'expiresIn'   => auth()->factory()->getTTL() * 60,
        ]);
    }
}