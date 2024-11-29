<?php
namespace App\Services\Shippings\Helpers;

class InputsUtility {
    public static array $default = array(
        'name'          => '',
        'label'         => '',
        'class'         => '',
        'col'           => '',
        'group'         => false,
        'title'         => '',
        'type'          => '',
        'value'         => '',
        'placeholder'   => '',
        'attributes'    => [],
        'show_if'       => null,
        'show'          => null,
        'cast'          => null,
        'setName'       => null,
    );

    public static array $allowedTypes = [
        'text',
        'label',
        'radio',
        'select',
        'hidden',
        'repeater'
    ];

    private static function text()
    {
        return ("
            <div class='form-group m-b-10'>
                <label class='control-label'>%1$s</label>
                <input type='text' name='%2$s' class='%3$s' value='%4$s' placeholder='%5$s' %6$s>
            </div>
        ");
    }

    private static function label()
    {

    }

    private static function radio()
    {

    }

    private static function select()
    {

    }

    private static function hidden()
    {

    }

    private static function repeater()
    {

    }

    public static function __callStatic($name, $arguments)
    {
        if ( ! in_array( $name,self::$allowedTypes ) ){
            return;
        }

        $arguments = array_merge( self::$default,$arguments );

        return self::$name( $arguments );
    }
}