<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class ChronoRelaisDomMethod extends ChronopostShipping implements MethodInterface
{
    private const ID = "chronorelaisdom";

    public const TITLE  = 'Chrono Relais Dom';

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
