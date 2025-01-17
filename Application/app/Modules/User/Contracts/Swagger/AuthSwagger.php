<?php

declare(strict_types=1);

namespace App\Modules\User\Contracts\Swagger;

use App\Modules\User\Requests\LoginUserRequest;
use App\Modules\User\Requests\RegisterUserRequest;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;

interface AuthSwagger
{
    /**
     * @OA\Post(
     *     path="/auth/register",
     *     tags={"Authentication"},
     *     summary="User Registration",
     *     description="Registers a new user and returns an authentication token.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/RegisterUserRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully registered and authenticated",
     *         @OA\JsonContent(
     *             @OA\Property(property="accessToken", type="string", description="Bearer token"),
     *             @OA\Property(property="tokenType", type="string", description="Bearer"),
     *             @OA\Property(property="expiresIn", type="integer", description="Token expiration time in seconds")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid input"),
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string"), description="List of validation errors")
     *         )
     *     )
     * )
     */
    public function register(RegisterUserRequest $request): JsonResponse;

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Authentication"},
     *     summary="User Login",
     *     description="Logs in a user and returns an authentication token.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/LoginUserRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged in",
     *         @OA\JsonContent(
     *             @OA\Property(property="accessToken", type="string", description="Bearer token"),
     *             @OA\Property(property="tokenType", type="string", description="Bearer"),
     *             @OA\Property(property="expiresIn", type="integer", description="Token expiration time in seconds")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Invalid credentials"),
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string"), description="List of validation errors")
     *         )
     *     )
     * )
     */
    public function login(LoginUserRequest $request): JsonResponse;

    /**
     * @OA\Post(
     *     path="/auth/logout",
     *     tags={"Authentication"},
     *     summary="User Logout",
     *     description="Logs out the user and invalidates the token.",
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Successfully logged out")
     *         )
     *     )
     * )
     */
    public function logout(): JsonResponse;

    /**
     * @OA\Post(
     *     path="/auth/refresh",
     *     tags={"Authentication"},
     *     summary="Refresh Token",
     *     description="Refreshes the user's authentication token.",
     *     @OA\Response(
     *         response=200,
     *         description="Successfully refreshed token",
     *         @OA\JsonContent(
     *             @OA\Property(property="accessToken", type="string", description="Bearer token"),
     *             @OA\Property(property="tokenType", type="string", description="Bearer"),
     *             @OA\Property(property="expiresIn", type="integer", description="Token expiration time in seconds")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *             @OA\Property(property="errors", type="array", @OA\Items(type="string"), description="List of error details")
     *         )
     *     )
     * )
     */
    public function refresh(): JsonResponse;
}
