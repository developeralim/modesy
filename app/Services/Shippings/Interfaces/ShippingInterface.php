<?php 
namespace App\Services\Shippings\Interfaces;
use stdClass;

interface ShippingInterface {
    public function setEntity( stdClass $entity ) : void;
    public function setSeller( stdClass $seller ) : void;
    public function setSellerTotal( int $total ) : void;
    public function calculateCost() : int;
    public function setCartItems( array $carts ) : void;
    public function setCurrency( stdClass $currency ) : void;
    public function getId() : int;
    public function renderInputForm() : string;
    public function getReadableName() : string;
    public function getInputs() : array;
}