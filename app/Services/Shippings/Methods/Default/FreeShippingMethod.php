<?php

namespace App\Services\Shippings\Methods\Default;

use App\Services\Shippings\DefaultShipping;
use App\Services\Shippings\Interfaces\MethodInterface;

class FreeShippingMethod extends DefaultShipping implements MethodInterface
{
    private const ID = "free_shipping";

    public int $is_free_shipping = 0;
    public int $free_shipping_min_amount = 0;

    public const TITLE  = 'Free Shipping';

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
        $freeShippingMinAmount = getPrice( $this->entity->free_shipping_min_amount, 'decimal');
        
        if ( \Config\Globals::$defaultCurrency->code != $this->currency->code) {
            $freeShippingMinAmount = convertCurrencyByExchangeRate($freeShippingMinAmount, $this->currency->exchange_rate);
        }
        
        if ( $this->sellerTotal >= $freeShippingMinAmount) {
            $this->is_free_shipping = 1;
            $this->free_shipping_min_amount = $freeShippingMinAmount;
            return 0;
        }
        
        return parent::calculateCost();
    }

    public function setInputs(): array
    {
        $language = \Config\Globals::$activeLang;
        $currency = \Config\Globals::$defaultCurrency;

        return [
            [
                'label'         => trans("minimum_order_amount"),
                'title'         => $currency->symbol,
                'type'          => 'text',
                'name'          => "free_shipping_min_amount",
                'class'         => 'form-control form-input price-input',
                'col'           => 'col-md-12 m-b-5',
                'group'         => true,
                'value'         => '',
                'placeholder'   => '0.00',
                'attributes'    => [
                    'maxlength' => 19
                ]
            ],
        ];
    }
}
