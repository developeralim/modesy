<?php 
namespace App\Services\Shippings;

use App\Services\Shippings\Interfaces\ShippingInterface;

abstract class BaseShipping implements ShippingInterface {
    public function __construct()
    {
        //Initialize the constructor
    }
}