<?php

declare(strict_types=1);

namespace App\Modules\Post\Contracts\Swagger;

use App\Http\Resources\MessagesResource;
use App\Modules\Post\Requests\PostsListRequest;
use App\Modules\Post\Requests\StorePostRequest;
use App\Modules\Post\Requests\UpdatePostRequest;
use App\Modules\Post\Resources\PostResource;
use App\Modules\Post\Resources\PostsResource;
use OpenApi\Annotations as OA;

interface PostSwagger
{
    /**
     * @OA\Get(
     *     path="/posts",
     *     summary="Get all posts",
     *     description="Retrieve a paginated list of posts",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="The page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="The number of posts per page",
     *         required=false,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="sort",
     *         in="query",
     *         description="Sort the posts by creation date",
     *         required=false,
     *         @OA\Schema(type="string", enum={"asc", "desc"}, example="asc")
     *     ),
     *     @OA\Parameter(
     *         name="title",
     *         in="query",
     *         description="Search for posts by title",
     *         required=false,
     *         @OA\Schema(type="string", example="Post title")
     *     ),
     *     @OA\Parameter(
     *         name="statusIds",
     *         in="query",
     *         description="Filter posts by status IDs",
     *         required=false,
     *         @OA\Schema(type="array", items=@OA\Items(type="integer"))
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="A paginated list of posts",
     *         @OA\JsonContent(ref="#/components/schemas/PostsResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid parameters",
     *     )
     * )
     */
    public function index(PostsListRequest $request): PostsResource;


    /**
     * @OA\Get(
     *     path="/posts/{id}",
     *     summary="Get a specific post",
     *     description="Retrieve a post by ID",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The post details",
     *         @OA\JsonContent(ref="#/components/schemas/PostResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function show(int $id): PostResource;


    /**
     * @OA\Post(
     *     path="/posts",
     *     summary="Create a new post",
     *     description="Create a new post with the provided data",
     *     tags={"Posts"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/StorePostRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post successfully created",
     *         @OA\JsonContent(ref="#/components/schemas/PostResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data"
     *     )
     * )
     */
    public function store(StorePostRequest $request): PostResource;


    /**
     * @OA\Post(
     *     path="/posts/{id}",
     *     summary="Update a specific post",
     *     description="Update the details of an existing post by ID",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UpdatePostRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post successfully updated",
     *         @OA\JsonContent(ref="#/components/schemas/PostResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function update(int $id, UpdatePostRequest $request): PostResource;


    /**
     * @OA\Delete(
     *     path="/posts/{id}",
     *     summary="Delete a post",
     *     description="Delete an existing post by ID",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of the post",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Post successfully deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Post successfully deleted")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post not found"
     *     )
     * )
     */
    public function destroy(int $id): MessagesResource;
}
