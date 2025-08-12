<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($e->getCode() == 405) {
            return redirect()->route('client.index');
        }

        if ($request->expectsJson()) {

            $output = [
                'success' => 0,
                'message' => $e->getMessage(),
            ];

            if ($e->getCode() == 405){
                $output['message'] = 'Method not allowed';
                $output['status'] = $statusCode = Response::HTTP_METHOD_NOT_ALLOWED;
            }
            else if ($e instanceof ValidationException) {
                $output['status'] = $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                $errors = $e->errors();
                $output['errors'] = array_map(function ($messages) {
                    return array_map('getTranslation', $messages);
                }, $errors);
            } elseif ($e instanceof AuthorizationException) {
                $output['status'] = $statusCode = Response::HTTP_UNAUTHORIZED;
            } elseif ($e instanceof \PDOException) {
                $output['status'] = $statusCode = Response::HTTP_NOT_FOUND;
                $output['message'] = App::isProduction() ? 'Not found' : $e->getMessage();
            } else {
                $output['status'] = $statusCode = method_exists($e, 'getStatusCode') ? $e->getStatusCode() : Response::HTTP_INTERNAL_SERVER_ERROR;
                $output['message'] = App::isProduction() ? 'Something went wrong' : $e->getMessage();
            }

            return response()->json($output, $statusCode);
        }

        return parent::render($request, $e);
    }
}
