<?php

namespace JamesGordo\LaravelPaypalCheckout\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use JamesGordo\LaravelPaypalCheckout\Order;

class ChargeController extends Controller
{
    /**
     * ChargeController.
     *
     * @param Request $request
     */
    public function __invoke(Request $request)
    {
        try {
            $capture = (new Order)->capture($request->token);
        } catch (Exception $e) {
            abort(500, 'Unable to Charge Order via Paypal.');
        }

        return redirect()->to(config('paypal.thank_you_page'));
    }
}
