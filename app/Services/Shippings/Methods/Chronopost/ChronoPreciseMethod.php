<?php

namespace App\Services\Shippings\Methods\Chronopost;

use App\Services\Shippings\ChronopostShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class ChronoPreciseMethod extends ChronopostShipping implements MethodInterface
{
    private const ID    = "chronoprecise";
    public const TITLE  = 'Chrono Precise';

    public static string $pretty_title         = 'Chronopost - Express delivery on appointment';
    public static string $title                = 'Chronopost - Express delivery on appointment';
    public static string $method_title         = 'Chronopost - Express delivery on appointment';
    public static string $method_description   = 'By appointment at your home! Order delivered on the day of your choice in a 2-hour time slot. You can reprogram your delivery in case of absence.';
    public static string $product_code         = '2O';
    public static string $product_code_str     = 'SRDV';

    public string $slot_option_key;
    public string $cost_level_option_key;

    public function __construct()
    {
        parent::__construct();

        $this->slot_option_key          = self::ID .  "_table_slots";
        $this->cost_level_option_key    = self::ID .  "_cost_levels";
    }

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
