<?php

return [
    'environment' => env('PAYPAL_API_ENVIRONMENT', 'sandbox'),
    'client_id' => env('PAYPAL_API_CLIENT_ID', ''),
    'client_secret' => env('PAYPAL_API_CLIENT_SECRET', ''),
    'return_url' => env('PAYPAL_API_RETURN_URL', ''),
    'cancel_url' => env('PAYPAL_API_CANCEL_URL', ''),
    'currency' => env('PAYPAL_API_CURRENCY', 'USD'),
    'thank_you_page' => env('PAYPAL_API_THANK_YOU_PAGE', '/checkout/success'),
];
