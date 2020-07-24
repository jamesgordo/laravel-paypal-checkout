<?php

namespace JamesGordo\LaravelPaypalCheckout;

use InvalidArgumentException;
use PayPalHttp\HttpException;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use Illuminate\Support\Facades\Log;

class Order
{
    /** @var PayPalCheckoutSdk\Core\PayPalHttpClient */
    private $client;

    /**
     * Order constructor.
     *
     * @return void
     */
    public function __construct()
    {
        // set api client environment
        $environment = config('paypal.environment') === 'production' ?
                        new ProductionEnvironment(
                            config('paypal.client_id'),
                            config('paypal.client_secret')
                        ) :
                        new SandboxEnvironment(
                            config('paypal.client_id'),
                            config('paypal.client_secret')
                        );

        // initialize client
        $this->client = new PayPalHttpClient($environment);
    }

    /**
     * Creates an Order in Paypal
     *
     * @param array $data
     * @return object
     */
    public function create(array $data): object
    {
        try {
            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = $this->buildRequestBody($data);

            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);

            // initialize payment url
            $paymentUrl = null;

            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    $paymentUrl = $link->href;

                    break;
                }
            }

            return (object) [
                'id' => $response->result->id,
                'amount' => (float) $response->result->purchase_units[0]->amount->value,
                'payment_url' => $paymentUrl,
                'status' => $response->result->status,
            ];
        } catch (HttpException $ex) {
            // log the error
            Log::error(sprintf(
                'PAYPAL_API_ERROR:: Code: %s | Message: %s',
                $ex->statusCode,
                $ex->getMessage()
            ));

            throw $ex;
        }
    }

    /**
     * Retrieves the Order details.
     *
     * @param string $id
     * @return object
     */
    public function read(string $id): object
    {
        try {
            $request = new OrdersGetRequest($id);

            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);

            return $response->result;
        } catch (HttpException $ex) {
            // log the error
            Log::error(sprintf(
                'PAYPAL_API_ERROR:: Code: %s | Message: %s',
                $ex->statusCode,
                $ex->getMessage()
            ));

            throw $ex;
        }
    }

    /**
     * Captures payment for an order.
     *
     * @param string $id
     * @return object
     */
    public function capture(string $id): object
    {
        try {
            $request = new OrdersCaptureRequest($id);
            $request->prefer('return=representation');

            // Call API with your client and get a response for your call
            $response = $this->client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            return (object) [
                'id' => $response->result->id,
                'payer' => [
                    'name' => sprintf(
                                '%s %s',
                                $response->result->payer->name->given_name,
                                $response->result->payer->name->surname
                            ),
                    'email' => $response->result->payer->email_address,
                ],
                'amount' => (float) $response->result->purchase_units[0]->amount->value,
                'status' => $response->result->status,
            ];
        } catch (HttpException $ex) {
            // log the error
            Log::error(sprintf(
                'PAYPAL_API_ERROR:: Code: %s | Message: %s',
                $ex->statusCode,
                $ex->getMessage()
            ));

            throw $ex;
        }
    }

    /**
     * Prepares the data to be sent to paypal
     *
     * @param array $data
     * @return array
     */
    private function buildRequestBody(array $data): array
    {
        if (!array_key_exists('amount', $data) || $data['amount'] == null) {
            throw new InvalidArgumentException('Invalid parameter amount passed.');
        }

        if (!array_key_exists('item', $data) || $data['item'] == null) {
            throw new InvalidArgumentException('Invalid parameter item passed.');
        }

        return [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'reference_id' => md5(time()),
                    'amount' => [
                        'value' => (string) $data['amount'],
                        'currency_code' => config('paypal.currency'),
                        'breakdown' => [
                            'item_total' => [
                                'value' => (string) $data['amount'],
                                'currency_code' => config('paypal.currency'),
                            ],
                        ],
                    ],
                    'items' => [
                        [
                            'name' => $data['item'],
                            'unit_amount' => [
                                'value' => (string) $data['amount'],
                                'currency_code' => config('paypal.currency'),
                            ],
                            'quantity' => 1,
                        ],
                    ],
                ],
            ],
            'application_context' => [
                'cancel_url' => config('paypal.cancel_url'),
                'return_url' => config('paypal.return_url'),
            ],
        ];
    }
}
