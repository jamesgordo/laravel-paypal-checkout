<?php

namespace JamesGordo\LaravelPaypalCheckout\Http\Controllers;

use Illuminate\Routing\Controller;

class ThankYouController extends Controller
{
    /**
     * Show the Thank You Page.
     *
     * @return View
     */
    public function __invoke()
    {
        return view('paypal.thankyou');
    }
}
