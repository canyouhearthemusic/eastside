<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => [],
                'errors'  => $e->errors(),
                'code'    => 418
            ], 418);
        }

        if ($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => [],
                'errors'  => [],
                'code'    => 404
            ], 404);
        }

        if ($e instanceof \DomainException) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => [],
                'errors'  => [],
                'code'    => $e->getCode()
            ], 422);
        }

        if ($e instanceof AccessDeniedHttpException) {
            return response()->json([
                'message' => $e->getMessage(),
                'data'    => [],
                'errors'  => [],
                'code'    => $e->getCode()
            ], 403);
        }

        return parent::render($request, $e);
    }
}
