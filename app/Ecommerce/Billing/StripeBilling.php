<?php



namespace Ecommerce\Billing;

use Stripe\Charge;
use Stripe\Error\Card;
use Stripe\Stripe;

class StripeBilling implements BillingInterface
{
    public function __construct()
    {
        $secret_key = \App\Payment::first()->stripe_secret_key;
        Stripe::setApiKey($secret_key);
    }

    public function charge(array $data)
    {
        try {
            return Charge::create([
                'amount'      => $data['amount'] * 100,
                'currency'    => 'usd',
                'description' => $data['email'],
                'source'      => $data['token'],
            ]);
        } catch (Card $e) {
            dd('Card was declined');
        }
    }
}
