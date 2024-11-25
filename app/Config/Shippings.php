<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Shippings extends BaseConfig
{
    // Register shippings
    public static array $shippings = [
        'default'       => \App\Services\Shippings\DefaultShipping::class,
        'mondial_relay' => \App\Services\Shippings\MondialRelayShipping::class,
        'chronopost'     => \App\Services\Shippings\ChronopostShipping::class,
    ];

    // Register Shipping methods
    public static array $methods = [
        "flat_rate"                         => \App\Services\Shippings\Methods\Default\FlatRateMethod::class,
        "free_shipping"                     => \App\Services\Shippings\Methods\Default\FreeShippingMethod::class,
        "local_pickup"                      => \App\Services\Shippings\Methods\Default\LocalPickupMethod::class,
        "mondial_relay_colis_drive"         => \App\Services\Shippings\Methods\Mondial\MondialColisDriveMethod::class,
        "mondial_relay_domicile_1_livreur"  => \App\Services\Shippings\Methods\Mondial\MondialDomicile1LivreurMethod::class,
        "mondial_relay_domicile_2_livreurs" => \App\Services\Shippings\Methods\Mondial\MondialDomicile2LivreurMethod::class,
        "mondial_relay_domicile_inf_30"     => \App\Services\Shippings\Methods\Mondial\MondialDomicileInf30Method::class,
        "mondial_relay_point_relais"        => \App\Services\Shippings\Methods\Mondial\MondialPointRelaisMethod::class,
        "chrono10"                          => \App\Services\Shippings\Methods\Chronopost\Chrono10Method::class,
        "chrono13"                          => \App\Services\Shippings\Methods\Chronopost\Chrono13Method::class,
        "chrono18"                          => \App\Services\Shippings\Methods\Chronopost\Chrono18Method::class,
        "chronoclassic"                     => \App\Services\Shippings\Methods\Chronopost\ChronoClassicMethod::class,
        "chronoexpress"                     => \App\Services\Shippings\Methods\Chronopost\ChronoExpressMethod::class,
        "chronoprecise"                     => \App\Services\Shippings\Methods\Chronopost\ChronoPreciseMethod::class,
        "chronorelaisdom"                   => \App\Services\Shippings\Methods\Chronopost\ChronoRelaisDomMethod::class,
        "chronorelaiseurope"                => \App\Services\Shippings\Methods\Chronopost\ChronoRelaisEuropeMethod::class,
        "chronorelais"                      => \App\Services\Shippings\Methods\Chronopost\ChronoRelaisMethod::class,
        "chronosameday"                     => \App\Services\Shippings\Methods\Chronopost\ChronoSameDayMethod::class,
        "chronotoshopdirect"                => \App\Services\Shippings\Methods\Chronopost\ChronoToShopDirectMethod::class,
        "chronotoeuropedirect"              => \App\Services\Shippings\Methods\Chronopost\ChronoToShopEuropeMethod::class,
    ];
}
