<?php

namespace App\Services\Shippings\Methods\Mondial;

use App\Services\Shippings\Interfaces\MethodInterface;
use App\Services\Shippings\MondialRelayShipping;

class MondialDomicileInf30Method extends MondialRelayShipping implements MethodInterface
{
    private const ID = "mondial_relay_domicile_inf_30";
    public const TITLE = 'Mondial Relay Domicile Inf 30';

    public static function getTitle(): string
    {
        return self::TITLE;
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
