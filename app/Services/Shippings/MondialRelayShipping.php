<?php 
namespace App\Services\Shippings;

class MondialRelayShipping extends BaseShipping {

    public function __construct()
    {
        parent::__construct();
    }

    public function getMethods(): array
    {
        return [
            
        ];
    }
}