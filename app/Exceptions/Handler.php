<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        $this->reportable(function (Throwable $exception) {
            //
        });

        if ($e instanceof MethodNotAllowedHttpException) {
            return response()->json(
                [
                    'error' => 'Method not allowed'
                ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        switch ($e) {
            case ($e instanceof MartinDeliveryException):
                return response()->json([
                                            'data' => [],
                                            'meta' => [
                                                'status' => [
                                                    'message' => $e->getMessage() ?? 'Internal Error'
                                                ]
                                            ]
                                        ], $e->getCode() !== 0 ? $e->getCode() : 500);
            case ($e instanceof HttpException):
                if ($e->getStatusCode() == 403) {
                    return response()->make('Permission Denied');
                }
                break;
            case ($e instanceof TokenMismatchException):
                if ($request->expectsJson()) {
                    return response()->json([
                                                'data' => [],
                                                'meta' => [
                                                    'status' => [
                                                        'message' => trans('errors.invalid_token')
                                                    ]
                                                ]
                                            ], 400);
                }
                break;
            default:
                //
        }


        return parent::render($request, $e);

    }
}
