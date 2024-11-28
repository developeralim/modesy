<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class Chrono10Method extends ChronopostShipping implements MethodInterface
{
    private const ID    = "chrono10";
    public const TITLE  = 'Chrono 10';

    public static string $pretty_title                 = "Chronopost - Express delivery at home before 10am";
    public static string $title                        = "Chronopost - Express delivery at home before 10am";
    public static string $method_title                 = "Chronopost - Express delivery at home before 10am";
    public static string $method_description           = "Parcels delivered the next day before 10am at your home. The day before delivery, You'll be notified by e-mail and SMS.";
    public static string $product_code                 = '02';
    public static string $product_code_str             = '10H';
    public static string $product_code_return          = '4S';
    public static string $product_code_return_service  = '180';

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
