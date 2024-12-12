<?php
// app/Exceptions/Handler.php
namespace App\Exceptions;
use Illuminate\Validation\ValidationException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Throwable;

class Handler extends \Illuminate\Foundation\Exceptions\Handler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
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
     * Report or log an exception.
     *
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function render($request, Throwable $exception)
    {
        $status = $exception instanceof \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface ? $exception->getStatusCode() : 500;
    
        return response()->json([
            'message' => $exception->getMessage() ?: 'Server Error',
            'status' => 'error'
        ], $status);
    }
}
