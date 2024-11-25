<?php

namespace App\Services\Shippings\Methods\Default;

use App\Services\Shippings\DefaultShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class FlatRateMethod extends DefaultShipping implements MethodInterface
{
    private const ID = "flat_rate";

    public const TITLE  = 'Flat Rate';

    public static function getTitle(): string
    {
        return self::TITLE;
    }

    public static function getName(): string
    {
        return self::ID;
    }
    public static function active(): bool
    {
        return true;
    }

    public function setInputs(): array
    {
        return [];
    } 
    
}
