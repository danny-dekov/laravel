<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
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

    /**
     * Custom error response format as requested in the project
     *
     * @param $request
     * @param Throwable $e
     * @return JsonResponse
     */
    public function render($request, Throwable $e)
    {
        return response()->json([
            'code' => -1,
            'data' => null,
            'errors' => match (true) {
                $e instanceof HttpResponseException => $e->getResponse(),
                $e instanceof AuthenticationException => $this->unauthenticated($request, $e),
                $e instanceof ValidationException => $this->convertValidationExceptionToResponse($e, $request),
                $e instanceof ModelNotFoundException => 'Object not found',
                //default => $this->renderExceptionResponse($request, $e),
                default => 'Internal Server Error',
            },
        ], 200); //200 requested in the project specification
    }
}
