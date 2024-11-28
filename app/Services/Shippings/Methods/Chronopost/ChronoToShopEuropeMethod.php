<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class ChronoToShopEuropeMethod extends ChronopostShipping implements MethodInterface
{
    private const ID    = "chronotoeuropedirect";
    public const TITLE  = 'Chrono To Europe Direct';

    public static string $pretty_title         = "Chronopost - Europe delivery in Pickup relay";
    public static string $title                = "Chronopost - Europe delivery in Pickup relay";
    public static string $method_title         = "Chronopost - Europe delivery in Pickup relay";
    public static string $method_description   = "Parcels delivered in 3 to 7 days to Europe in the Pickup point of your choice.";
    public static string $product_code         = '6B';
    public static string $product_code_str     = '6B';
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
