<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class ChronoRelaisMethod extends ChronopostShipping implements MethodInterface
{
    private const ID    = "chronorelais";
    public const TITLE  = 'Chrono Relais';

    public static string $pretty_title         = 'Chronopost - Express delivery in Pickup relay';
    public static string $title                = 'Chronopost - Express delivery in Pickup relay';
    public static string $method_title         = 'Chronopost - Express delivery in Pickup relay';
    public static string $method_description   = "Parcels delivered the next day before 13h in the Pickup of your choice. You'll be notified by e-mail and SMS.";
    public static string $product_code         = '86';
    public static string $product_code_str     = 'PR';
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
