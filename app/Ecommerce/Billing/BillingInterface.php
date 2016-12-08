<?php namespace App\Ecommerce\Billing;

interface BillingInterface
{
    public function charge(array $data);
}
