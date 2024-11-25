<?php

namespace App\Services\Shippings\Methods\Default;

use App\Services\Shippings\DefaultShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class LocalPickupMethod extends DefaultShipping implements MethodInterface
{
    private const ID = "local_pickup";

    public const TITLE  = 'Local Pickup';

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
    public function calculateCost(): int
    {
        return getPrice($this->entity->local_pickup_cost, 'decimal');
    }

    public function setInputs(): array
    {
        return [];
    }
}
