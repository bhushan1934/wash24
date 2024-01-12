<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Throwable;

class Handler extends ExceptionHandler
{

    public function render($request, Throwable $exception)

{
    // Handle token expiration
    if ($exception instanceof TokenExpiredException) {
        return response()->json(['message' => 'Token has expired'], 401);
    }

    // Handle unauthorized access
    if ($exception instanceof AuthenticationException) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    // Handle route not found
    if ($exception instanceof RouteNotFoundException) {
        return response()->json(['message' => 'Route not found'], 404);
    }

    return parent::render($request, $exception);
}
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
}
