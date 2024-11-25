<?php 
namespace App\Services\Shippings\Interfaces;

interface MethodInterface {
    public static function active() : bool;
    public static function getName() : string;
    public function setInputs() : array;
    public static function getTitle() : string;
}