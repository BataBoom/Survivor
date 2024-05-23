<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;

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

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthorizationException) {

            if($request->route('pool')) {
                return redirect()->route('forbidden.pool', ['pool' => $request->route('pool')]);
            } else {
                return response()->json([
                    'error' => 'Forbidden',
                    'message' => 'You do not have permission to access this resource.'
                ], 403);
            }
        }

        return parent::render($request, $exception);
    }
}
