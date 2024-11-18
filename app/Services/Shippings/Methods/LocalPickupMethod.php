<?php

namespace App\Services\Shippings\Methods;

class LocalPickupMethod extends BaseMethod
{
    public static function active(): bool
    {
        return true;
    }
}
