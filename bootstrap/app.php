<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

function errorResponse($message, $code)
{
    return response()->json([
        "code" => $code,
        "message" => $message,
    ], $code);
}

function convertValidationExceptionToResponse(ValidationException $e, $request)
{
    if ($e->response) {
        return $e->response;
    }

    return str_contains($request->getPathInfo(), '/api/')
        ? errorResponse($e->validator->errors()->getMessages(), 400)
        : null;
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (Exception $e) {
            if ($e instanceof ValidationException) {
                return convertValidationExceptionToResponse($e, request());
            }

            if ($e->getPrevious() && $e->getPrevious() instanceof ModelNotFoundException) {
                $model = class_basename($e->getPrevious()->getModel());
                return errorResponse("{$model} not found", 404);
            }

            if ($e instanceof NotFoundHttpException) {
                return errorResponse($e->getMessage(), 404);
            }

            if ($e instanceof MethodNotAllowedHttpException) {
                return errorResponse('Method not allowed for this URL', 405);
            }

            if ($e instanceof HttpException) {
                return errorResponse($e->getMessage(), $e->getStatusCode());
            }

            if ($e instanceof QueryException) {
                $errorCode = $e->errorInfo[1];
                if ($errorCode == 1451) {
                    return errorResponse('Cannot remove this resource. It is related with any other resource', 409);
                }
            }

            return errorResponse($e->getMessage(), 500);
        });
    })->create();
