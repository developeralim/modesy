<?php 
namespace App\Services\Shippings;

class DefaultShipping extends BaseShipping {
    const TITLE = "Default Shipping";

    public function getShippingId()
    {
        return 'default';
    }
}