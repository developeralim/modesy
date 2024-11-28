<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class Chrono18Method extends ChronopostShipping implements MethodInterface
{
    private const ID    = "chrono18";
    public const TITLE  = 'Chrono 18';

    public static string $pretty_title                  = "Chronopost - Express delivery at home before 6pm";
    public static string $title                         = "Chronopost - Express delivery at home before 6pm";
    public static string $method_title                  = "Chronopost - Express delivery at home before 6pm";
    public static string $method_description            = "Parcels delivered the next day before 6pm at your home. The day before delivery, You'll be notified by e-mail and SMS.";
    public static string $product_code                  = '16';
    public static string $product_code_bal              = '2M';
    public static string $product_code_str              = '18H';
    public static string $product_code_bal_str          = '18H BAL';
    public static string $product_code_return           = '4U';
    public static string $product_code_return_service   = '835';

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
