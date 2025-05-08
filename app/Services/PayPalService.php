<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class PayPalService
{
    public static function client()
    {
        $clientId = config('paypal.client_id');
        $clientSecret = config('paypal.client_secret');
        $mode = config('paypal.mode');

        $environment = $mode === 'sandbox'
            ? new SandboxEnvironment($clientId, $clientSecret)
            : new ProductionEnvironment($clientId, $clientSecret);

        return new PayPalHttpClient($environment);
    }
}
