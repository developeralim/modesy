<?php 
namespace App\Services\Shippings;

use App\Services\Shippings\Helpers\ChronopostUtility;
use App\Services\Shippings\Traits\Chronopost\Package;
use App\Services\Shippings\Traits\Chronopost\WebService;

class ChronopostShipping extends BaseShipping {

    use WebService,Package;

    const TITLE     = "Chronopost";
    const API_URL   = 'https://www.chronopost.fr/shipping-cxf/ShippingServiceWS?wsdl';

    protected $configs = [];

    public array $methods       = [
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
    
    public array $products = [
        'chrono10'              => 'MODESY_Chrono10',
        'chrono13'              => 'MODESY_Chrono13',
        'chrono18'              => 'MODESY_Chrono18',
        'chronoclassic'         => 'MODESY_Chronoclassic',
        'chronoexpress'         => 'MODESY_Chronoexpress',
        'chronoprecise'         => 'MODESY_ChronoPrecise',
        'chronorelais'          => 'MODESY_Chronorelais',
        'chronorelaisdom'       => 'MODESY_ChronoRelaisDom',
        'chronorelaiseurope'    => 'MODESY_ChronoRelaisEurope',
        'chronosameday'         => 'MODESY_Chronosameday',
        'chronotoshopdirect'    => 'MODESY_ToShopDirect',
        'chronotoshopeurope'    => 'MODESY_ToShopEurope',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->configs = [
            'chrono_parcels_number'      => 1,
            'chrono_parcels_dimensions'  => array(
                1 => [
                    'height' => 12,
                    'width'  => 20,
                    'length' => 14,
                    'weight' => 1.5
                ]
            )
        ];
    }

    public function getShippingId()
    {
        return 'chronopost';
    }

    public function getStatus()
    {
        return ' <label class="label label-default">Shipped</label>';
    }

    public function getContractInfo() : array
    {
        return [
            'accountNumber'     => '19869502',
            'subAccountNumber'  => '',
            'accountLabel'      => 'Contrat TEST',
            'chrnopostPassword' => '255562'
        ];
    }

    public function withShipper()
    {
        $this->payload['shipperValue']['shipperAdress1'     ] = '3 avenue Gallieni';
        $this->payload['shipperValue']['shipperAdress2'     ] = 'test';
        $this->payload['shipperValue']['shipperCity'        ] = 'Gentilly';
        $this->payload['shipperValue']['shipperCivility'    ] = 'M';
        $this->payload['shipperValue']['shipperContactName' ] = 'Centre de service Chronopost';
        $this->payload['shipperValue']['shipperCountry'     ] = 'FR';
        $this->payload['shipperValue']['shipperEmail'       ] = 'demandez.a.chronopost@chronopost.fr';
        $this->payload['shipperValue']['shipperMobilePhone' ] = '';
        $this->payload['shipperValue']['shipperName'        ] = 'Chronopost SAS';
        $this->payload['shipperValue']['shipperName2'       ] = 'Md Alim Khan';
        $this->payload['shipperValue']['shipperPhone'       ] = '0 825 885 866';
        $this->payload['shipperValue']['shipperPreAlert'    ] = '';
        $this->payload['shipperValue']['shipperZipCode'     ] = '94250';
    }

    public function withCustomer()
    {
        $buyer = $this->getBuyer();

        $this->payload['customerValue']['customerAdress1'     ] = '3 avenue Gallieni';
        $this->payload['customerValue']['customerAdress2'     ] = 'test';
        $this->payload['customerValue']['customerCity'        ] = 'Gentilly';
        $this->payload['customerValue']['customerCivility'    ] = 'M';
        $this->payload['customerValue']['customerContactName' ] = 'Centre de service Chronopost';
        $this->payload['customerValue']['customerCountry'     ] = 'FR';
        $this->payload['customerValue']['customerEmail'       ] = 'demandez.a.chronopost@chronopost.fr';
        $this->payload['customerValue']['customerMobilePhone' ] = '';
        $this->payload['customerValue']['customerName'        ] = 'Chronopost SAS';
        $this->payload['customerValue']['customerName2'       ] = 'Md Alim Khan';
        $this->payload['customerValue']['customerPhone'       ] = '0 825 885 866';
        $this->payload['customerValue']['customerPreAlert'    ] = '';
        $this->payload['customerValue']['customerZipCode'     ] = '94250';
    }

    public function withRecipient() 
    {
        $shippingAddress = $this->getBuyerShippingAddress();
        
        $this->payload['recipientValue']['recipientAdress1'    ] = $shippingAddress->sAddress;
        $this->payload['recipientValue']['recipientAdress2'    ] = $shippingAddress->sTitle;
        $this->payload['recipientValue']['recipientCity'       ] = $shippingAddress->sCity;
        $this->payload['recipientValue']['recipientContactName'] = $shippingAddress->sFirstName .' '. $shippingAddress->sLastName;
        $this->payload['recipientValue']['recipientCountry'    ] = getCountry($shippingAddress->sCountryId)?->iso_code;
        $this->payload['recipientValue']['recipientEmail'      ] = $shippingAddress->sEmail;
        $this->payload['recipientValue']['recipientMobilePhone'] = '';
        $this->payload['recipientValue']['recipientName'       ] = $shippingAddress->sFirstName;
        $this->payload['recipientValue']['recipientName2'      ] = '';
        $this->payload['recipientValue']['recipientPhone'      ] = $shippingAddress->sPhoneNumber;
        $this->payload['recipientValue']['recipientPreAlert'   ] = '';
        $this->payload['recipientValue']['recipientZipCode'    ] = $shippingAddress->sZipCode;
    }

    public function registerParcelsFromOrder()
    {
        $this->saveAndCreateShipmentLabel();
    }

    public function settings(): array
    {
        return [];
    }
}