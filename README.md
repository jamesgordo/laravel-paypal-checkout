# Laravel Paypal Checkout

Simple Laravel Paypal Checkout implementation.

## Installation
Via composer
```
composer require jamesgordo/laravel-paypal-checkout
```

Add the package service provider to `config/app.php`
```
...
...

/*
 * Package Service Providers...
 */
JamesGordo\LaravelPaypalCheckout\Providers\CheckoutServiceProvider::class,

...
...
```

## Configuration
Publish the package config using the following command
```
php artisan vendor:publish --tag=paypal-checkout
```
A new config file will be created in the following path  **`config/paypal.php`**. Update the values from your paypal account
```
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

```
Override the values in the **`.env`** file:
```
PAYPAL_API_ENVIRONMENT=sandbox
PAYPAL_API_CLIENT_ID=XXXXXX
PAYPAL_API_CLIENT_SECRET=XXXXX
PAYPAL_API_RETURN_URL=https://YOURDOMAIN.COM/paypal/authorize
PAYPAL_API_CANCEL_URL=https://YOURDOMAIN.COM/checkout
PAYPAL_API_CURRENCY=USD
PAYPAL_API_THANK_YOU_PAGE=/checkout/success
```

The sample default views are also published in this **`resources/views/paypal`**

## Usage
You can access the example checkout page in this route.
```
YOURDOMAIN.COM/checkout
```
You can edit this view in **`resources/views/paypal/checkout.blade.php`**

If you wish to create you own checkout page, make sure to submit your form on this endpoint 
```
POST  YOURDOMAIN.COM/paypal/orders
```
The request body should have the following form data:  
| Field   |      Value      | Required |
|----------|:-------------:|------:|
| amount | Numeric | Yes |
| item | String | Yes |
<br/>

If you wish to create your own thank you page, make sure to update your **`.env`** file.
```
PAYPAL_API_THANK_YOU_PAGE=/my-custom-thank-you-page-route
```
