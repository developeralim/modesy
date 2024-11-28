<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class ChronoRelaisEuropeMethod extends ChronopostShipping implements MethodInterface
{
    private const ID    = "chronorelaiseurope";
    public const TITLE  = 'Chrono Relais Europe';

    public static string $pretty_title          = "Chronopost - Europe delivery in Pickup relay";
    public static string $title                 = "Chronopost - Europe delivery in Pickup relay";
    public static string $method_title          = "Chronopost - Europe delivery in Pickup relay";
    public static string $method_description    = "Parcels delivered in 2 to 6 days to Europe in the Pickup point of your choice.";
    public static string $product_code          = '49';
    public static string $product_code_str      = 'PRU';
    public static int $max_product_weight       = 20;
    public static string $product_code_return   = '3T';

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
