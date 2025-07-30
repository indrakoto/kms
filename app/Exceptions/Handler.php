<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Helpers\TelegramErrorHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        // Misalnya ValidationException, AuthenticationException, dsb
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        // Anda bisa mendaftarkan callback global error handling di sini, jika diperlukan
        $this->reportable(function (Throwable $e) {
            // Optional code
            TelegramErrorHandler::report($e);
        });
    }

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        // Panggil parental report dulu
        //parent::report($exception);

        // Kirim error ke Telegram via helper
        //TelegramErrorHandler::sendTelegramError($exception);
    }

    // Opsi lain seperti render() tetap bisa Anda sesuaikan di sini jika diperlukan
}
