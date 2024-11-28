<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class ChronoSameDayMethod extends ChronopostShipping implements MethodInterface
{
    private const ID    = "chronosameday";
    public const TITLE  = 'Chrono Same Day';

    public static string $pretty_title         = "Chronopost - Same-day delivery at home";
    public static string $title                = "Chronopost - Same-day delivery at home";
    public static string $method_title         = "Chronopost - Same-day delivery at home";
    public static string $method_description   = "Until the last minute, reprogram your delivery with Predict.";
    public static string $product_code         = '4I';
    public static string $product_code_str     = 'SMD';

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
