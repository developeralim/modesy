<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Shippings extends BaseConfig
{
    // Register shippings
    public array $shippings = [
        \App\Services\Shippings\DefaultShipping::class
    ];
}
