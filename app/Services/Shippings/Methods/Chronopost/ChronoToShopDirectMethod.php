<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class ChronoToShopDirectMethod extends ChronopostShipping implements MethodInterface
{
    private const ID    = "chronotoshopdirect";
    public const TITLE  = 'Chrono To Shop Direct';

    public static string $pretty_title         = "Chronopost - Delivery in Pickup relay";
    public static string $title                = "Chronopost - Delivery in Pickup relay";
    public static string $method_title         = "Chronopost - Delivery in Pickup relay";
    public static string $method_description   = "Parcels delivered in 2 to 3 days in the Pickup point of your choice. You'll be notified by e-mail.";
    public static string $product_code         = '5X';
    public static string $product_code_str     = '5X';
    public static int $max_product_weight      = 20;
    public static string $product_code_return  = '5Y';

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
