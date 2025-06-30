<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;
// use App\YourShoppingCartNamespace\ShoppingCart;
use App\Models\ShoppingCart; // Update this to the correct namespace of your ShoppingCart class

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    public function render($request, Throwable $exception){

        if ($exception instanceof HttpException && $exception->getStatusCode() === 400) {
            $majCategories = DB::table('majorcategories')->where('enabled', 1)->get();
            $subCategories = DB::table('categories')->where('majorcategories_id', 1)->get();
            $shoppingCart = new ShoppingCart();
            $cart = $shoppingCart->getCart();
            return response()->view('errors.400', [
                'message' => 'Oops! Bad input. Check your request and try again.',
                'referenceId' => uniqid('ERR400_'),
                'majCategories' => $majCategories,
                'subCategories' => $subCategories,
                'cart' => $cart,
            ], 400);
        }

        return parent::render($request, $exception);
    }

}
