<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class ChronoClassicMethod extends ChronopostShipping implements MethodInterface
{
    private const ID    = "chronoclassic";
    public const TITLE  = 'Chrono Classic';

    public static string $pretty_title         = "Chronopost - Delivery at home";
    public static string $title                = "Chronopost - Delivery at home";
    public static string $method_title         = "Chronopost - Delivery at home";
    public static string $method_description   = "Parcels delivered to Europe in 1 to 3 days";
    public static string $product_code         = '44';
    public static string $product_code_str     = 'CClassic';

    public static function getTitle(): string
    {
        return self::$pretty_title;
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
