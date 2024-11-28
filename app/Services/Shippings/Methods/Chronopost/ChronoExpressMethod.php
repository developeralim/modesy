<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class ChronoExpressMethod extends ChronopostShipping implements MethodInterface
{
    private const ID    = "chronoexpress";
    public const TITLE  = 'Chrono Express';

    public static string $pretty_title             = "Chronopost - Express delivery at home";
    public static string $title                    = "Chronopost - Express delivery at home";
    public static string $method_title             = "Chronopost - Express delivery at home";
    public static string $method_description       = "Parcels delivered to Europe in 1 to 3 days, 48 hours to the DOM and 2 to 5 days to the rest of the world.";
    public static string $product_code             = '17';
    public static string $product_code_str         = 'EI';

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
