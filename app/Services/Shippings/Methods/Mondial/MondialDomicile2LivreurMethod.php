<?php

namespace App\Services\Shippings\Methods\Mondial;

use App\Services\Shippings\Interfaces\MethodInterface;
use App\Services\Shippings\MondialRelayShipping;

class MondialDomicile2LivreurMethod extends MondialRelayShipping implements MethodInterface
{
    private const ID = "mondial_relay_domicile_2_livreurs";
    public const TITLE = 'Mondial Relay Domicile 2 Livreur';

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
