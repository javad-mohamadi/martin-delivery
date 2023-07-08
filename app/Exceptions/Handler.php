<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

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
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        switch ($e) {
            case ($e instanceof LogicException):
            case ($e instanceof TokenMismatchException):
                $statusCode = $e->getCode() != 0 ? $e->getCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
                break;
            case ($e instanceof HttpException):
            case ($e instanceof MethodNotAllowedHttpException):
                $statusCode = $e->getStatusCode() ?? Response::HTTP_INTERNAL_SERVER_ERROR;
                break;
            default:
                return parent::render($request, $e);
        }
        $response =
            [
                'status'  => 'failed',
                'message' => $e->getMessage(),
            ];


        return response()->json($response, $statusCode);
    }
}
