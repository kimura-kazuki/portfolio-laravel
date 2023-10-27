<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
     * フォーム有効期限切れで Page Expired をリダイレクト
     */
    public function render($request, Throwable $exception)
    {
        $class = get_class($exception);
        if ($class == 'Illuminate\Session\TokenMismatchException') {
            return back()->withInput()->withErrors("フォームの有効期限が切れました。\n再度お試しください。");
        }
        return parent::render($request, $exception);
    }
}
