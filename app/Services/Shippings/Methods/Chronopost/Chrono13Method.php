<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class Chrono13Method extends ChronopostShipping implements MethodInterface
{
    private const ID        = "chrono13";
    public const TITLE      = 'Chrono 13';

    public static string $pretty_title                 = 'Chronopost - Express delivery at home before 1pm';
    public static string $title                        = 'Chronopost - Express delivery at home before 1pm';
    public static string $method_title                 = 'Chronopost - Express delivery at home before 1pm';
    public static string $method_description           = "Parcels delivered the next day before 1pm at your home. The day before delivery, You'll be notified by e-mail and SMS"; // Description shown in admin
    public static string $product_code                 = '01';
    public static string $product_code_str             = '01';
    public static string $product_code_return          = '4T';
    public static string $product_code_return_service  = '898';

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
