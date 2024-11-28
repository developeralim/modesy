<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class ChronoRelaisDomMethod extends ChronopostShipping implements MethodInterface
{
    private const ID    = "chronorelaisdom";
    public const TITLE  = 'Chrono Relais Dom';

    public static string $pretty_title         = "Chronopost - Overseas departments delivery in Pickup relay";
    public static string $title                = "Chronopost - Overseas departments delivery in Pickup relay";
    public static string $method_title         = "Chronopost - Overseas departments delivery in Pickup relay";
    public static string $method_description   = "Parcels delivered in 3 to 4 days to the DOM in the Pickup point of your choice.";
    public static string $product_code         = '4P';
    public static string $product_code_str     = '4P';
    public static int $max_product_weight      = 20;

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
