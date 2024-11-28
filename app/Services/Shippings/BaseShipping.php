<?php 
namespace App\Services\Shippings;

use App\Models\ShippingModel;
use App\Services\Shippings\Interfaces\MethodInterface;
use App\Services\Shippings\Interfaces\ShippingInterface;
use GuzzleHttp\Client;
use stdClass;
/**
 * @method string getName();
 * @method array setInputs();
 * @method null|MethodInterface getMethod();
 */
abstract class BaseShipping implements ShippingInterface {

    var $payload = [];
	var $errors = [];

    public array $methods = [];

    const TITLE = '';

    /**
     * Order Entity
     */
    protected ?stdClass $order = null;

    /**
     * Database entity record
     */
    protected ?stdClass $entity = null;

    /**
     * Seller 
     */
    protected stdClass $seller;

    /**
     * Buyer
     */
    protected ?stdClass $buyer = null;

    /**
     * Freeshipping amount
     */
    protected int $freeShippingMinAmount;

    /**
     * Local pickup cost
     */
    protected int $localPickupCost;

    /**
     * Seller total
     */
    protected int $sellerTotal;

    /**
     * Cart Items Array
     */ 
    protected array $cartItems = array();

    /**
     * Currency
     */

    protected stdClass $currency;

    /**
     * Cost
     */
    public int $cost = 0;

    /**
     * UniqId 
     */
    public string $uniqid = '';

    /**
     * Is this method is selected or not
     */
    public int $is_selected = 0;

    /**
     * Client
     */
    protected $client;

    public function __construct()
    {
        ini_set('default_socket_timeout', 5000);

        $this->uniqid = uniqid();
        $this->seller = user();
        $this->client = \Config\Services::curlrequest();
    }

    public function setEntity(stdClass $entity): void
    {
        $this->entity = $entity;
    }

    public function getReadableName( $string = null ) : string
    {
        return @parseSerializedNameArray($string ?? $this->entity->name_array, selectedLangId());
    }

    public function setSeller(stdClass $seller): void
    {
        $this->seller = $seller;
    }
    

    public function setSellerTotal( int $total ) : void
    {
        $this->sellerTotal = $total;
    }

    public function setCartItems(array $carts): void
    {
        $this->cartItems = $carts;
    }

    public function setCurrency(stdClass $currency): void
    {
        $this->currency = $currency;
    }

    public function setOrder( stdClass $order )
    {
        $this->order = $order;
    }

    public function setBuyer( stdClass $buyer )
    {
        $this->buyer = $buyer;
    }

    public function calculateCost(): int
    {
        $totalCost = 0;
        
        foreach ( $this->cartItems as $cartItem) {
            if ($cartItem->seller_id == $this->seller->id && $cartItem->product_type == 'physical') {
                $cost = $this->entity->flat_rate_cost;
                
                if ( ! empty( $cartItem->shipping_class_id ) ) {
                    $classCost = getShippingClassCostByMethod($this->entity->shipping_classes_array, $cartItem->shipping_class_id);
                    if (!empty($classCost)) {
                        $cost = getPrice($classCost,'database');
                    }
                }
                if ($this->entity->flat_rate_cost_calculation_type == 'each_product') {
                    $totalCost += ( $cost * $cartItem->quantity );
                } elseif ($this->entity->flat_rate_cost_calculation_type == 'each_different_product') {
                    $totalCost += $cost;
                } elseif ($this->entity->flat_rate_cost_calculation_type == 'cart_total') {
                    if ($cost > $totalCost) {
                        $totalCost = $cost;
                    }
                } elseif( $this->entity->flat_rate_cost_calculation_type == 'price_rule' ) {
                    $totalCost = $cost;
                }
            }
        }

        if ( ! empty($totalCost) ) {
            $totalCost = getPrice($totalCost, 'decimal');
        }

        return $this->cost = $totalCost;
    }

    public function getId(): int
    {
        return $this->entity->id;
    }

    public function getInputs() : array 
    {
        $language = \Config\Globals::$activeLang;
        $currency = \Config\Globals::$defaultCurrency;

        $classes = (new ShippingModel)->getActiveShippingClasses( $this->seller->id );
        $classes = array_map(function($class){
            $class->name_array = $this->getReadableName($class->name_array);
            return $class;
        },$classes);

        $enableStatusAttributes = [];
        $disableStatusAttribute = [];

        $extra_inputs = null;

        if ( $this->entity ) {
            $this->entity->status == 1 ? ( $enableStatusAttributes['checked'] = true ) : ($disableStatusAttribute['checked'] = true);
            $extra_inputs = json_decode($this->entity->extra_inputs,true);
        }

        $inputs = array_merge([
            [
                'label'         => trans("method_name"),
                'type'          => 'text',
                'name'          => "method_name",
                'cast'          => function( $value ){
                    if ( is_array($value) || is_object( $value ) ) {
                        return json_encode($value);
                    }
                    return (string) $value;
                },
                'class'         => 'form-control form-input m-b-5',
                'col'           => 'col-md-12',
                'value'         => $this->entity ? $this->getReadableName() : trans($this->getName()),
                'placeholder'   => esc($language->name),
                'attributes'    => [
                    'maxlength' => 255
                ],
            ],
            [
                'label'         => trans("status"),
                'type'          => 'label',
                'col'           => 'col-sm-12 col-xs-12',
            ],
            [
                'label'         => trans("enable"),
                'type'          => 'radio',
                'name'          => "status",
                'cast'          => function( $value ){
                    if ( ! is_array( $value ) && ! is_object($value) ){
                        return intval($value);
                    }
                    return 0;
                },
                'class'         => 'custom-control-input',
                'col'           => 'col-md-6 col-sm-12 m-b-5',
                'value'         => '1',
                'attributes'    => $enableStatusAttributes
            ],
            [
                'label'         => trans("disable"),
                'type'          => 'radio',
                'name'          => "status",
                'cast'          => function( $value ){
                    if ( ! is_array( $value ) && ! is_object($value) ){
                        return intval($value);
                    }
                    return 0;
                },
                'class'         => 'custom-control-input',
                'col'           => 'col-md-6 col-sm-12 m-b-5',
                'value'         => '0',
                'attributes'    => $disableStatusAttribute
            ],
        ],$this->setInputs());

        if ( $this->getName() != 'free_shipping' ) {
            $inputs[] = [
                'label'         => trans("cost"),
                'title'         => $currency->symbol,
                'type'          => 'text',
                'name'          => $this->getName() == 'local_pickup' ? "local_pickup_cost" : "flat_rate_cost",
                'cast'          => function( $value ){
                    return getPrice($value,'database');
                },
                'class'         => 'form-control form-input price-input',
                'col'           => 'col-md-12',
                'group'         => true,
                'value'         => $this->entity ? getPrice($this->entity->flat_rate_cost,'input') : '',
                'placeholder'   => '0.00',
                'attributes'    => [
                    'maxlength' => 19
                ]
            ];
        }

        foreach( $classes as $class ) {
            if ( $class->status == 1 ) {
                $value = '0.00';

                if ( $this->entity && $classCosts = json_decode( $this->entity->shipping_classes_array,true ) ) {
                    $value = $classCosts[$class->id];
                }

                $inputs[] = [
                    'label'         => "\"".$class->name_array . "\" shipping class cost",
                    'title'         => $currency->symbol,
                    'type'          => 'text',
                    'name'          => 'shipping_classes_array',
                    'cast'          => function( $value ){
                        return json_encode($value);
                    },
                    'class'         => 'form-control form-input price-input',
                    'col'           => 'col-md-12',
                    'group'         => true,
                    'value'         => $value,
                    'placeholder'   => '0.00',
                    'attributes'    => [
                        'maxlength' => 19,
                    ],
                    'setName'       => function( $baseName ) use( $class ) {
                        return "{$baseName}[shipping_classes_array][{$class->id}]";
                    }
                ];
            }
        }

        if ( $this->getName() !== 'free_shipping' && $this->getName() !== 'local_pickup' ) {
            $inputs[] = [
                'label'         => trans("cost_calculation_type"),
                'type'          => 'select',
                'name'          => "flat_rate_cost_calculation_type",
                'cast'          => function( $value ){
                    if ( is_array($value) || is_object( $value ) ) {
                        return json_encode($value);
                    }
                    return (string) $value;
                },
                'class'         => 'form-control custom-select',
                'col'           => 'col-md-12 m-b-5',
                'value'         => $this->entity ? $this->entity->flat_rate_cost_calculation_type : '',
                'options'       => [
                    'each_product'              => trans("charge_shipping_for_each_product"),
                    'each_different_product'    => trans("charge_shipping_for_each_different_product"),
                    'cart_total'                => trans("fixed_shipping_cost_for_cart_total"),
                    'price_rule'                => trans('price_rule')
                ],
                'attributes'    => [
                    "id"    => "cost_calculation_type_" . $this->uniqid
                ]
            ];
        }

        $inputs[] = [
            'label'         => trans("from"),
            'title'         => $currency->symbol,
            'type'          => 'text',
            'name'          => 'price_rule',
            'class'         => 'form-control form-input price-input',
            'col'           => 'col-md-6',
            'group'         => true,
            'value'         => $extra_inputs && ! empty( $extra_inputs['price_rule']['from'] ) ? $extra_inputs['price_rule']['from'] : '',
            'placeholder'   => '0.00',
            'attributes'    => [
                'maxlength' => 19
            ],
            'show_if'       => "#cost_calculation_type_{$this->uniqid}:price_rule",
            "show"          => ! empty( $extra_inputs['price_rule']['from'] ),
            'setName'       => function($baseName){
                return "{$baseName}[price_rule][from]";
            }
        ];

        $inputs[] = [
            'label'         => trans("to"),
            'title'         => $currency->symbol,
            'type'          => 'text',
            'name'          => 'price_rule',
            'class'         => 'form-control form-input price-input',
            'col'           => 'col-md-6',
            'group'         => true,
            'value'         => $extra_inputs && ! empty( $extra_inputs['price_rule']['to'] ) ? $extra_inputs['price_rule']['to'] : '',
            'placeholder'   => '0.00',
            'attributes'    => [
                'maxlength' => 19
            ],
            'show_if'       => "#cost_calculation_type_{$this->uniqid}:price_rule",
            "show"          => ! empty( $extra_inputs['price_rule']['to'] ),
            'setName'       => function($baseName){
                return "{$baseName}[price_rule][to]";
            }
        ];
        

        if ( $this->entity ) {
            $inputs[] = [
                'type'  => 'hidden',
                'name'  => 'id',
                'value' => $this->entity->id,
                'col'   => 'col-12'
            ];
        }

        return $inputs;
    }

    public function renderInputForm(): string
    {
        $inputs         = $this->getInputs();
        $baseName       = "methods[{$this->getName()}]" . "[".$this->uniqid."]";
        return $this->inputsWalker( $inputs,$baseName );
    }

    private function inputsWalker( $inputs = [],$baseName = '' ) : string
    {
        $htmlContent    = '<div class="row">';

        foreach( $inputs as $index => $input ) {

            $input['id'] = uniqid('input-box-');

            extract($input);

            if ( $type !== 'label' ) {

                $attributesFormat   = '';

                if ( ! empty( $attributes ) ) {
                    array_walk( $attributes,function( $value,$name ) use( &$attributesFormat ) {
                        $attributesFormat .= "{$name} = \"{$value}\"";
                    });
                }
    
                $name = isset( $setName ) && is_callable( $setName ) ? call_user_func($setName,$baseName) : "{$baseName}[{$name}]";
    
                if ( ! empty( $attributes['multiple'] ) ) {
                    $name = "{$name}[]";
                }

            }

            $htmlContent .= sprintf(
                "<div class='%s' style='%s' id='%s'>",
                $col ?? '',
                ! empty( $show_if ) && empty( $show ) ? 'display:none;' : '',
                $id,
            );

            switch ( $input['type'] ) {
                
                case 'text': 
                    if ( empty( $group ) ) {
                        $htmlContent .= sprintf('
                            <div class="form-group m-b-10">
                                <label class="control-label">%1$s</label>
                                <input type="text" name="%2$s" class="%3$s" value="%4$s" placeholder="%5$s" %6$s>
                            </div>
                        ',$label,$name,$class,$value,$placeholder,$attributesFormat);
                    } else {
                        $htmlContent .= sprintf('
                            <div class="form-group m-b-10">
                                <label class="control-label">%1$s</label>
                                <div class="input-group">
                                    <span class="input-group-addon">%2$s</span>
                                    <input type="text" name="%3$s" value="%4$s" placeholder="%5$s" %6$s class="%7$s">
                                </div>
                            </div>
                        ',$label,$title,$name,$value,$placeholder,$attributesFormat,$class);
                    }
                    break;
                case 'label' : 
                    $htmlContent .= sprintf('
                        <label>%1$s</label>
                    ',$label);
                    break;
                case 'radio' : 
                    $htmlContent .= sprintf('
                        <div class="custom-control custom-radio">
                            <input type="radio" name="%1$s" id="%1$s_%2$s" %3$s value="%4$s" class="%5$s">
                            <label for="%1$s_%2$s" class="custom-control-label">%6$s</label>
                        </div>
                    ',$name,$index,$attributesFormat,$value,$class,$label);
                    break;
                case 'select' : 

                    $optionsFormat = "";
                    
                    array_walk ( $options,function( $n,$v ) use(&$optionsFormat,$value){
                        $selected = "";

                        if ( ( is_array( $value ) && in_array($v,$value) ) || ( is_string($value) && $value == $v ) ) {
                            $selected = "selected";
                        }   

                        $optionsFormat .= "<option {$selected} value='{$v}'>{$n}</option>";
                    });

                    $htmlContent .= sprintf('
                        <div class="form-group">
                            <label>%1$s</label>
                            <select name="%2$s" class="%3$s" %4$s>
                                %5$s
                            </select>
                        </div>
                    ',$label,$name,$class,$attributesFormat,$optionsFormat);
                    break;
                case 'hidden' : 
                    $htmlContent .= sprintf('<input type="hidden" name="%s" value="%s" />',$name,$value);
                    break;
            }

            $htmlContent .= "</div>";

            if ( ! empty( $show_if ) ) {

                list($target,$targetValue) = array_pad(explode(":",$show_if),2,'');

                $htmlContent .= sprintf('
                    <script>
                        if ( $(`%1$s`).length ) {
                            $(`%1$s`).on("change",function(){
                                if( $(this).val() == "%2$s" ) {
                                    $(document).find(`#%3$s`).show();
                                } else {
                                    $(document).find(`#%3$s`).hide();
                                }
                            });
                        }
                    </script>
                ',$target,$targetValue,$id );
            }

            foreach( $input as $key => $val ) {
                unset($$key);
            }
        }

        $htmlContent .= '</div>';

        return $htmlContent;
    }

    public function getMethod()
    {
        static $method = null;
        if ( ! $method &&  $methodType = getShippingMethod($this->order->shipping_method)?->method_type ) {
            $method = ! empty( $this->methods[ $methodType ] ) ? new $this->methods[ $methodType ] : null;
        }
        return $method;
    }

    public function getBuyer()
    {
        return $this->buyer;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getBuyerShippingAddress()
    {
        static $shippingAddress = null;

        if ( $this->order && ! $shippingAddress ) {
            $shippingAddress = unserialize($this->order->shipping);
        }
        
        return $shippingAddress;
    }

    public function getMethodName()
    {
        if ( $this->getMethod() ) {
            return $this->getMethod()::getTitle();
        }
    }

    public function getShippingName()
    {
        return static::TITLE;
    }

    public function insuranceAmount()
    {
        return '<small>Not Active</small>';
    }

    public function trackingNumber()
    {
        return '';
    }

    abstract public function settings() : array;

    public function settingsForm()
    {
        $settings = $this->settings();

        foreach( $settings as $setting ) {
            switch ( $setting['type'] ) {
                case 'repeater':
                    
                    break;
            }
        }
    }
}