<?php

namespace App\Services\Shippings\Methods\Mondial;

use App\Services\Shippings\Interfaces\MethodInterface;
use App\Services\Shippings\MondialRelayShipping;

class MondialPointRelaisMethod extends MondialRelayShipping implements MethodInterface
{
    private const ID = "mondial_relay_point_relais";
    public const TITLE = 'Mondial Relay Point Relais';

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
