<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class ChronoToShopEuropeMethod extends ChronopostShipping implements MethodInterface
{
    private const ID = "chronotoeuropedirect";

    public const TITLE  = 'Chrono To Europe Direct';

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
