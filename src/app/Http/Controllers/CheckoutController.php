<?php

namespace JamesGordo\LaravelPaypalCheckout\Http\Controllers;

use Illuminate\Routing\Controller;

class CheckoutController extends Controller
{
    /**
     * Show the Checkout Page.
     *
     * @return View
     */
    public function __invoke()
    {
        return view('paypal.checkout');
    }
}
