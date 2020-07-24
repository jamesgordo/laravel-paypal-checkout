<?php

// default checkout page
Route::get('checkout', 'CheckoutController')->middleware('web');

// default thank you page
Route::get('checkout/success', 'ThankYouController');

Route::group(['prefix' => 'paypal'], function () {
    Route::post('orders', 'OrderController@create');
    Route::put('orders/{id}/charge', 'OrderController@charge');

    // handle paypal redirect after payment
    Route::get('authorize', 'ChargeController');
});
