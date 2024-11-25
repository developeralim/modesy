<?php

namespace App\Services\Shippings\Methods\Mondial;

use App\Services\Shippings\Interfaces\MethodInterface;
use App\Services\Shippings\MondialRelayShipping;

class MondialDomicile1LivreurMethod extends MondialRelayShipping implements MethodInterface
{
    private const ID = "mondial_relay_domicile_1_livreur";
    public const TITLE = 'Mondial Relay Domicile 1 Livreur';

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
