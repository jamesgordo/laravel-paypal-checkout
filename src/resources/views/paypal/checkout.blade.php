<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Laravel Paypal Checkout</title>
    <meta name="description" content="Laravel Paypal Checkout">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        html, body{
          height: 100%;
        }
    </style>
</head>
<body class="bg-light">
    <div id="app" class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-4 col-offset-4">
                <form id="paypal-form" method="POST" action="/paypal/orders">
                    @csrf

                    <div class="form-group">
                        <label for="amount">Enter Amount</label>
                        <input type="number" class="form-control" id="amount" placeholder="$0" name="amount">
                        <input type="hidden" name="item" value="Donation">
                    </div>

                    <div class="form-group">
                        <button id="submit" class="btn btn-primary btn-block" type="submit">
                            <i class="fa fa-paypal mr-2" aria-hidden="true"></i>
                            PAY VIA PAYPAL
                        </button>

                        <button id="loading" class="btn btn-primary btn-block d-none" disabled="disabled">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </buttton>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="//code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="//stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script>
        $('#submit').on('click',function(event){
            // Do some stuff here
            $(this).addClass('d-none');
            $('#loading').removeClass('d-none');
        });
    </script>
</body>
</html>
