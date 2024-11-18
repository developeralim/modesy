<?php 
namespace App\Services\Shippings;

class DefaultShipping extends BaseShipping {

    public function __construct()
    {
        parent::__construct();
    }

    public function getMethods(): array
    {
        return [
            \App\Services\Shippings\Methods\FlatRateMethod::class,
            \App\Services\Shippings\Methods\FreeShippingMethod::class,
            \App\Services\Shippings\Methods\LocalPickupMethod::class,
        ];
    }
}