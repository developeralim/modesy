<?php

namespace App\Services\Shippings\Methods;

class FlatRateMethod extends BaseMethod
{
    public static function active(): bool
    {
        return true;
    }
}
