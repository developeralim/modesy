<?php

namespace App\Services\Shippings\Methods;

class FreeShippingMethod extends BaseMethod
{
    public static function active(): bool
    {
        return true;
    }
}
