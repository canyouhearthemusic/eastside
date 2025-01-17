<?php

declare(strict_types=1);

namespace App\Modules\Post\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @OA\Get(
 *     path="/audio/play/{path}",
 *     summary="Play an audio by pathname",
 *     description="Play an audio by pathname",
 *     tags={"Audio"},
 *     @OA\Parameter(
 *         name="path",
 *         in="path",
 *         description="Path of the file(post audiofile)",
 *         required=true,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="The audio file content",
 *         content={
 *             @OA\MediaType(
 *                 mediaType="audio/mpeg",
 *             )
 *         }
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Audiofile not found"
 *     )
 * )
 */
final class AudioController extends Controller
{
    public function play(string $path): BinaryFileResponse
    {
        $decodedPath = urldecode($path);

        return Response::file(
            Storage::path($decodedPath),
            [
                'Content-Type'        => 'audio/mpeg',
                'Content-Disposition' => 'inline; filename="audio.mp3"',
                'Accept-Ranges'       => 'bytes',
            ]
        );
    }
}
