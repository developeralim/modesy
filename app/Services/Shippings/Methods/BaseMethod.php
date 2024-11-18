<?php 
namespace App\Services\Shippings\Methods;

use App\Services\Shippings\Interfaces\MethodInterface;

abstract class BaseMethod implements MethodInterface {
    public string $name = '';
    public function __construct()
    {
        //Initialize the constructor
    }
}