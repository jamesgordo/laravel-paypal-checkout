<?php

namespace JamesGordo\LaravelPaypalCheckout\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use JamesGordo\LaravelPaypalCheckout\Order;
use JamesGordo\LaravelPaypalCheckout\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    /**
     * Creates a new Order in Paypal
     *
     * @param OrderRequest $request
     * @return Illuminate\Http\Response
     */
    public function create(OrderRequest $request)
    {
        // perform validation
        $request->validated();

        try {
            $data = [
                'amount' => $request->getAmount(),
                'item' => $request->getItem(),
            ];

            $order = (new Order)->create($data);

            return redirect()->to($order->payment_url);
        } catch (Exception $e) {
            $this->response = [
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($this->response);
    }

    /**
     * Captures the Order in Paypal
     *
     * @param string $id
     * @return Illuminate\Http\Response
     */
    public function read($id)
    {
        try {
            $this->response['data'] = (new Order)->read($id);
        } catch (Exception $e) {
            $this->response = [
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($this->response);
    }

    /**
     * Captures the Order in Paypal
     *
     * @param string $id
     * @return Illuminate\Http\Response
     */
    public function capture($id)
    {
        try {
            $this->response['data'] = (new Order)->capture($id);
        } catch (Exception $e) {
            $this->response = [
                'code' => 500,
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($this->response);
    }
}
