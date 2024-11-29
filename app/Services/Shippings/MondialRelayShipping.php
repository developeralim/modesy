<?php 
namespace App\Services\Shippings;

use SoapClient;

class MondialRelayShipping extends BaseShipping {

    const TITLE                 = "Mondial Relay";
    const TRACKING_API_KEY      = "";
    const API_URL               = 'https://api.mondialrelay.com/Web_Services.asmx?wsdl';

    var $error_code             = 1;
    var $error_message          = '';

    const ID_SHIPPING_METHODS_RELAY = [
        'mondial_relay_point_relais',
    ];

    protected $fields = array(
        'Enseigne' => array(
            'required' => true,
            'regex' => '#^[0-9A-Z]{2}[0-9A-Z ]{6}$#',
        ),
        'ModeCol' => array(
            'required' => true,
            'regex' => '#^(CCC|CDR|CDS|REL)$#',
        ),
        'ModeLiv' => array(
            'required' => true,
            'regex' => '#^(LCC|LD1|LDS|24R|ESP|DRI|HOM)$#',
        ),
        'NDossier' => array(
            'regex' => '#^(|[0-9A-Z_ -]{0,15})$#',
        ),
        'NClient' => array(
            'regex' => '#^(|[0-9A-Z]{0,9})$#',
        ),
        'Expe_Langage' => array(
            'required' => true,
            'regex' => '#^[A-Z]{2}$#',
        ),
        'Expe_Ad1' => array(
            'required' => true,
            'regex' => '#^[0-9A-Z_\-\'., /]{2,32}$#',
        ),
        'Expe_Ad2' => array(
            'regex' => '#^[0-9A-Z_\-\'., /]{0,32}$#',
        ),
        'Expe_Ad3' => array(
            'required' => true,
            'regex' => '#^[0-9A-Z_\-\'., /]{0,32}$#',
        ),
        'Expe_Ad4' => array(
            'regex' => '#^[0-9A-Z]{2}[0-9A-Z ]{6}$#',
        ),
        'Expe_Ville' => array(
            'required' => true,
            'regex' => '#^[A-Z_\-\' 0-9]{2,26}$#',
        ),
        'Expe_CP' => array(
            'required' => true,
        ),
        'Expe_Pays' => array(
            'required' => true,
            'regex' => '#^[A-Z]{2}$#',
        ),
        'Expe_Tel1' => array(
            'required' => true,
            'regex' => '#^((00|\+)[1-9]{2}|0)[0-9][0-9]{7,9}$#',
        ),
        'Expe_Tel2' => array(
            'regex' => '#^((00|\+)[1-9]{2}|0)[0-9][0-9]{7,9}$#',
        ),
        'Expe_Mail' => array(
            'regex' => '#^[\w\-\.\@_]{0,70}$#',
        ),
        'Dest_Langage' => array(
            'required' => true,
            'regex' => '#^FR|ES|NL$#',
        ),
        'Dest_Ad1' => array(
            'required' => true,
            'regex' => '#^[0-9A-Z_\-\'., /]{2,32}$#',
        ),
        'Dest_Ad2' => array(
            'regex' => '#^[0-9A-Z_\-\'., /]{2,32}$#',
        ),
        'Dest_Ad3' => array(
            'required' => true,
            'regex' => '#^[0-9A-Z_\-\'., /]{2,32}$#',
        ),
        'Dest_Ad4' => array(
            'regex' => '#^[0-9A-Z_\-\'., /]{0,32}$#',
        ),
        'Dest_Ville' => array(
            'required' => true,
            'regex' => '#^[A-Z_\-\' 0-9]{2,26}$#',
        ),
        'Dest_CP' => array(
            'required' => true,
        ),
        'Dest_Pays' => array(
            'required' => true,
            'regex' => '#^[A-Z]{2}$#',
        ),
        'Dest_Tel1' => array(
            'regex' => '#^((00|\+)[1-9]{2}|0)[0-9][0-9]{7,9}$#',
        ),
        'Dest_Tel2' => array(
            'regex' => '#^((00|\+)[1-9]{2}|0)[0-9][0-9]{7,9}$#',
        ),
        'Dest_Mail' => array(
            'regex' => '#^[\w\-\.\@_]{0,70}$#',
        ),
        'Poids' => array(
            'required' => true,
            'regex' => '#^1[5-9]$|^[2-9][0-9]$|^[0-9]{3,7}$#',
        ),
        'Longueur' => array(
            'regex' => '#^[0-9]{0,3}$#',
        ),
        'Taille' => array(
            'regex' => '#^(XS|S|M|L|XL|XXL|3XL)$#',
        ),
        'NbColis' => array(
            'required' => true,
            'regex' => '#^[0-9]{1,2}$#',
        ),
        'CRT_Valeur' => array(
            'required' => true,
            'regex' => '#^[0-9]{1,7}$#',
        ),
        'CRT_Devise' => array(
            'regex' => '#^(|EUR)$#',
        ),
        'Exp_Valeur' => array(
            'regex' => '#^[0-9]{0,7}$#',
        ),
        'Exp_Devise' => array(
            'regex' => '#^(|EUR)$#',
        ),
        'COL_Rel_Pays' => array(
            'regex' => '#^[A-Z]{2}$#',
        ),
        'COL_Rel' => array(
            'regex' => '#^(|[0-9]{6})$#',
        ),
        'LIV_Rel_Pays' => array(
            'regex' => '#^[A-Z]{2}$#',
        ),
        'LIV_Rel' => array(
            'regex' => '#^(|[0-9]{6})$#',
        ),
        'TAvisage' => array(
            'regex' => '#^(|O|N)$#',
        ),
        'TReprise' => array(
            'regex' => '#^(|O|N)$#',
        ),
        'Montage' => array(
            'regex' => '#^(|[0-9]{1,3})$#',
        ),
        'TRDV' => array(
            'regex' => '#^(|O|N)$#',
        ),
        'Assurance' => array(
            'regex' => '#^(|[0-9A-Z]{1})$#',
        ),
        'Instructions' => array(
            'regex' => '#^[0-9A-Z_\-\'., /]{0,31}#',
        ),
        'Security' => array(
            'regex' => '#^[0-9A-Z]{32}$#',
        ),
        'Texte' => array(
            'regex' => '#^([^<>&\']{3,30})(\(cr\)[^<>&\']{0,30}){0,9}$#',
        ),
    );

    protected $configs = [];

    public function __construct()
    {
        parent::__construct();

        $this->configs = [
            'mondial_relay_customer_code'       => 'CC214F7W',
            'mondial_relay_private_key'         => '7NmZ4KbT',
            'brand_code'                        => 41,
            'mondial_relay_shipper_civility'    => 'M',
            'mondial_relay_shipper_name'        => 'Ed Douib',
            'mondial_relay_shipper_name_2'      => 'Abderrazak',
            'mondial_relay_shipper_address_1'   => '9 enamel street',
            'mondial_relay_shipper_address_2'   => '',
            'mondial_relay_shipper_zip_code'    => '93200',
            'mondial_relay_shipper_city'        => 'Saint Denis',
            'mondial_relay_shipper_country'     => 'FR',
            'mondial_relay_shipper_phone'       => '+33660959002',
            'mondial_relay_shipper_email'       => 'Abderrazak.eddouib@yahoo.fr',
        ];
    }

    public array $methods       = [
        "mondial_relay_colis_drive"         => \App\Services\Shippings\Methods\Mondial\MondialColisDriveMethod::class,
        "mondial_relay_domicile_1_livreur"  => \App\Services\Shippings\Methods\Mondial\MondialDomicile1LivreurMethod::class,
        "mondial_relay_domicile_2_livreurs" => \App\Services\Shippings\Methods\Mondial\MondialDomicile2LivreurMethod::class,
        "mondial_relay_domicile_inf_30"     => \App\Services\Shippings\Methods\Mondial\MondialDomicileInf30Method::class,
        "mondial_relay_point_relais"        => \App\Services\Shippings\Methods\Mondial\MondialPointRelaisMethod::class,
    ];

    public function getShippingId()
    {
        return 'mondial_relay';
    }

    public function getStatus($params = [])
    {
        return '<label class="label label-default">Shipped</label>';

        if (empty($params)) return false;
        $client = new SoapClient(self::API_URL);
        $result = $client->WSI2_TracingColisDetaille($params);

        return $result->WSI2_TracingColisDetailleResult;
    }

    public function getActions() : string 
    {
        $actions = sprintf('
            <form action="%s" method="post" class="m-l-5 ">
                <input type="hidden" name="shipping" value="mondial_relay"/>
                <input type="hidden" name="sale" value="%d"/>
                <button type="submit" class="btn btn-sm btn-primary">
                    <i class="fa fa-truck" aria-hidden="true"></i> Generate label
                </button>
                %s
            </form>',
            generateDashUrl('sales/shipment/generate-label'),
            $this->order->id,
            csrf_field()
        );
        return $actions;
    }

    public function getPickupPoints( $params )
    {
        if (empty($params)) return false;

        $client = new SoapClient( self::API_URL, [
            'trace'              => true,
            'cache_wsdl'         => WSDL_CACHE_NONE,
            'connection_timeout' => 5000,
        ]);

        $result = $client->WSI4_PointRelais_Recherche($params);
       
        return $result->WSI4_PointRelais_RechercheResult;

        return false;
    }

    public function registerParcels($params)
    {
        $client = new SoapClient( self::API_URL, ['trace' => true]);
       
        $result = $client->WSI2_CreationEtiquette($params);
        
        return $result->WSI2_CreationEtiquetteResult;
    }

    public function getLabelsFromApi($label_URL)
    {
        $label_URL = 'https://www.mondialrelay.com'.$label_URL;

        $response   = $this->client->request('GET', $label_URL );
        $http_code  = $response->getStatusCode();
        $pdf_body   = $response->getBody();

        if ('200' != $http_code) {
            return false;
        }

        return ($pdf_body);
    }

    public function getErrorMessages($error_code)
    {
        $error_messages = [
            '0'  => "Opération effectuée avec succès",
            '1'  => 'Enseigne invalide',
            '2'  => 'Numéro d\'enseigne vide ou inexistant',
            '3'  => 'Numéro de compte enseigne invalide',
            '8'  => 'Mot de passe ou hachage invalide',
            '5'  => 'Numéro de dossier enseigne invalide',
            '7'  => 'Numéro de client enseigne invalide(champ NCLIENT)',
            '9'  => 'Ville non reconnu ou non unique',
            '10' => 'Type de collecte invalide',
            '11' => 'Numéro de Relais de Collecte invalide',
            '12' => 'Pays de Relais de collecte invalide',
            '13' => 'Type de livraison invalide',
            '14' => 'Numéro de Relais de livraison invalide',
            '15' => 'Pays de Relais de livraison invalide',
            '20' => 'Poids du colis invalide',
            '21' => 'Taille(Longueur + Hauteur) du colis invalide',
            '22' => 'Taille du Colis invalide',
            '24' => 'Numéro d\'expédition ou de suivi invalide',
            '26' => 'Temps de montage invalide',
            '27' => 'Mode de collecte ou de livraison invalide',
            '28' => 'Mode de collecte invalide',
            '29' => 'Mode de livraison invalide. Rappel : 1 Colis max pour l\'offre "Start"',
            '30' => 'Adresse(L1) invalide',
            '31' => 'Adresse(L2) invalide',
            '33' => 'Adresse(L3) invalide',
            '34' => 'Adresse(L4) invalide',
            '35' => 'Ville invalide',
            '36' => 'Code postal invalide',
            '37' => 'Pays invalide',
            '38' => 'Numéro de téléphone invalide',
            '39' => 'Adresse e-mail invalide',
            '40' => 'Paramètres manquants',
            '42' => 'Montant CRT invalide',
            '43' => 'Devise CRT invalide',
            '44' => 'Valeur du colis invalide',
            '45' => 'Devise de la valeur du colis invalide',
            '46' => 'Plage de numéro d\'expédition épuisée',
            '47' => 'Nombre de colis invalide',
            '48' => 'Multi - Colis Relais Interdit',
            '49' => 'Action invalide',
            '60' => 'Champ texte libre invalide(Ce code erreur n\'est pas invalidant)',
            '61' => 'Top avisage invalide',
            '62' => 'Instruction de livraison invalide',
            '63' => 'Assurance invalide',
            '64' => 'Temps de montage invalide',
            '65' => 'Top rendez - vous invalide',
            '66' => 'Top reprise invalide',
            '67' => 'Latitude invalide',
            '68' => 'Longitude invalide',
            '69' => 'Code Enseigne invalide',
            '70' => 'Numéro de Point Relais invalide',
            '71' => 'Nature de point de vente non valide',
            '74' => 'Langue invalide',
            '78' => 'Pays de Collecte invalide',
            '79' => 'Pays de Livraison invalide',
            '80' => 'Code tracing : Colis enregistré',
            '81' => 'Code tracing : Colis en traitement chez Mondial Relay',
            '82' => 'Code tracing : Colis livré',
            '83' => 'Code tracing : Anomalie',
            '84' => '(Réservé Code Tracing)',
            '85' => '(Réservé Code Tracing)',
            '86' => '(Réservé Code Tracing)',
            '87' => '(Réservé Code Tracing)',
            '88' => '(Réservé Code Tracing)',
            '89' => '(Réservé Code Tracing)',
            '92' => 'Le code pays du destinataire et le code pays du Point Relais doivent être identiques ou Solde insuffisant(comptes prépayés)',
            '93' => 'Aucun élément retourné par le plan de tri Si vous effectuez une collecte ou une livraison en Point Relais, vérifiez que les Point Relais sont bien disponibles.Si vous effectuez une livraison à domicile, il est probable que le code postal que vous avez indiqué n\'existe pas.',
            '94' => 'Colis Inexistant',
            '95' => 'Compte Enseigne non activé',
            '96' => 'Type d\'enseigne incorrect en Base',
            '97' => 'Clé de sécurité invalide Cf. : § «Génération de la clé de sécurité»',
            '98' => 'Erreur générique(Paramètres invalides) Cette erreur masque une autre erreur de la liste et ne peut se produire que dans le cas où le compte utilisé est en mode «Production».Cf. : § «Fonctionnement normal et débogage»',
            '99' => 'Erreur générique du service. Cette erreur peut être due à un problème technique du service. Veuillez notifier cette erreur à Mondial Relay en précisant la date et l\'heure de la requête ainsi que les paramètres envoyés afin d\'effectuer une vérification.',
        ];

        if (isset($error_messages[$error_code])) return $error_messages[$error_code];

        return '';
    }

    public function buildOutcomePayload()
    {
        if (empty($this->with_account())) return false;
        if (empty($this->with_shipping_method())) return false;
        if (empty($this->with_shipper())) return false;
        if (empty($this->with_recipient())) return false;
        if (empty($this->with_packages())) return false;
        if (empty($this->with_additional_params(false))) return false;
        if (empty($this->with_security())) return false;

        return true;
    }

    
    public function build_income_payload($order)
    {
        if (empty($this->with_account())) return false;
        if (empty($this->with_shipping_method())) return false;
        if (empty($this->with_shipper())) return false;
        if (empty($this->with_recipient())) return false;
        if (empty($this->with_packages())) return false;
        if (empty($this->with_additional_params())) return false;
        if (empty($this->with_security())) return false;

        return true;
    }


    public function build_tracking_payload($order)
    {
        if (empty($this->with_account())) return false;
        if (empty($this->with_tracking_number($order))) return false;
        if (empty($this->with_language())) return false;

        if (empty($this->with_security())) return false;


        return true;
    }

    public function with_account()
    {
        $missing_fields = $this->check_required_fields('account');

        if ( ! empty($missing_fields)) {

            $this->errors[] = sprintf(
                'Some fields are missing in "Account Information" section, please check your %s',
                '<a href="#">Check the documentations</a>'
            );

            return false;
        }

        $this->payload['Enseigne'] = $this->configs['mondial_relay_customer_code'];
       
        return $this;
    }

    public function with_shipping_method()
    {
        if ( ! $this->buyer ) {
            return false;
        }
      
        $this->payload['ModeCol']   = 'CCC';
        $this->payload['ModeLiv']   = 'LCC';
        $this->payload['NDossier']  = $this->order->id;
        $this->payload['NClient']   = $this->buyer->id;

        return $this;
    }


    public function with_shipper()
    {
        $missing_fields = $this->check_required_fields('shipper');

        if (!empty($missing_fields)) {
            $this->errors[] = sprintf(
                'Some fields are missing in "Shipping Address" section, please check your %s',
                '<a href="#">Mondial Relay configuration page</a>'
            );

            return false;
        }
    
        if ( true ) {

            $expe_Ad1 = strtoupper(remove_accents($this->configs['mondial_relay_shipper_civility'])).' '.
                        substr(strtoupper(remove_accents($this->configs['mondial_relay_shipper_name'])), 0, 100).' '.
                        substr(strtoupper(remove_accents($this->configs['mondial_relay_shipper_name_2'])), 0, 100);
            
            $this->payload['Expe_Langage']  = "FR";
            $this->payload['Expe_Ad1']      = preg_replace("#[^0-9A-Za-z_\-'., \/]#i", '', substr(strtoupper(remove_accents($expe_Ad1)), 0, 32));
            $this->payload['Expe_Ad2']      = '';
            $this->payload['Expe_Ad3']      = preg_replace("#[^0-9A-Za-z_\-'., \/]#i", '', substr(strtoupper(remove_accents( $this->configs['mondial_relay_shipper_address_1'] )), 0, 32));
            $this->payload['Expe_Ad4']      = preg_replace("#[^0-9A-Za-z_\-'., \/]#i", '', substr(strtoupper(remove_accents( $this->configs['mondial_relay_shipper_address_2'] )), 0, 32));
            $this->payload['Expe_Ville']    = substr(strtoupper(remove_accents( $this->configs['mondial_relay_shipper_city'] )), 0, 26);
            $this->payload['Expe_CP']       = substr(strtoupper(remove_accents( $this->configs['mondial_relay_shipper_zip_code'] )), 0, 10);
            $this->payload['Expe_Pays']     = substr(strtoupper(remove_accents( $this->configs['mondial_relay_shipper_country'] )), 0, 2);
            $this->payload['Expe_Tel1']     = preg_replace('/\s|(\+33|0033)(\d)/', '0$2', preg_replace('/[^0-9\+\-]/', '', substr( $this->configs['mondial_relay_shipper_phone'] , 0, 13)));
            $this->payload['Expe_Tel2']     = preg_replace('/\s|(\+33|0033)(\d)/', '0$2', preg_replace('/[^0-9\+\-]/', '', substr( $this->configs['mondial_relay_shipper_phone'], 0, 13)));
            $this->payload['Expe_Mail']     = substr(strtoupper(remove_accents( $this->configs['mondial_relay_shipper_email'] )), 0, 70);
        }

        return $this;
    }

    public function with_recipient()
    {
        $shipping_address = unserialize( $this->order->shipping );
        
        if ( true ) {
            
            $this->payload['Dest_Langage']  = 'FR';
            $this->payload['Dest_Ad1']      = preg_replace("#[^0-9A-Za-z_\-'., \/]#i", '', substr(remove_accents($shipping_address->sFirstName.' '.$shipping_address->sLastName), 0, 32));
            $this->payload['Dest_Ad2']      = preg_replace("#[^0-9A-Za-z_\-'., \/]#i", '', substr(remove_accents($shipping_address->sTitle), 0, 32));
            $this->payload['Dest_Ad3']      = preg_replace("#[^0-9A-Za-z_\-'., \/]#i", '', substr(remove_accents($shipping_address->sAddress), 0, 32));

            if (!in_array( 'shipping method here', self::ID_SHIPPING_METHODS_RELAY)) {
                $this->payload['Dest_Ad4'] = preg_replace("#[^0-9A-Za-z_\-'., \/]#i", '', substr(remove_accents($shipping_address->sAddress), 0, 32));
            } else {
                $this->payload['Dest_Ad4'] = '';
            }
                
            $this->payload['Dest_Ville'] = substr(remove_accents($shipping_address->sCity), 0, 50);
            $this->payload['Dest_CP']   = substr(((strlen($shipping_address->sZipCode) == 4 && "French" == $shipping_address->sCountry) ? "0".$shipping_address->sZipCode : $shipping_address->sZipCode), 0, 9);
            $this->payload['Dest_Pays'] = substr(remove_accents($shipping_address->sCountry), 0, 2);
            $this->payload['Dest_Tel1'] = preg_replace('/\s|(\+33|0033)(\d)/', '0$2', preg_replace('/[^0-9\+\-]/', '', substr($shipping_address->sPhoneNumber, 0, 13)));
            $this->payload['Dest_Tel2'] = preg_replace('/\s|(\+33|0033)(\d)/', '0$2', preg_replace('/[^0-9\+\-]/', '', substr($shipping_address->sPhoneNumber, 0, 13)));
            $this->payload['Dest_Mail'] = substr($shipping_address->sEmail ? $shipping_address->sEmail : $shipping_address->sEmail, 0, 70);
        }

        return $this;
    }

    public function with_packages()
    {
        $this->payload['Poids']         = '14';
        $this->payload['Longueur']      = '20';
        $this->payload['Taille']        = '';
        $this->payload['NbColis']       = 1;

        return $this;
    }

    private function with_additional_params()
    {
        $pickup_info = '';

        $this->payload['CRT_Valeur']        = '0';
        $this->payload['CRT_Devise']        = 'EUR';
        $this->payload['Exp_Valeur']        = round(intval(1000 / 100));
        $this->payload['Exp_Devise']        = 'EUR';
        $this->payload['COL_Rel_Pays']      = '';
        $this->payload['COL_Rel']           = '';
        $this->payload['LIV_Rel_Pays']      = substr(remove_accents('FR'), 0, 2);

        if (!empty($pickup_info['pickup_id'])) {
            $this->payload['LIV_Rel'] = 'pickup_id';
        }

        $this->payload['TAvisage']          = '';
        $this->payload['TReprise']          = '';
        $this->payload['Montage']           = '';
        $this->payload['TRDV']              = '';
        $this->payload['Assurance']         = '';
        $this->payload['Instructions']      = '';

        return $this;
    }

    protected function with_tracking_number()
    {
        $this->payload['Expedition'] = 'traking number';
        return true;
    }

    protected function with_language()
    {
        $this->payload['Langue'] = substr('FR', -2);
        return true;
    }

    protected function with_security()
    {
        $code    = implode("", $this->payload);
        $code   .= $this->configs['mondial_relay_private_key'];

        $this->payload["Security"] = strtoupper(md5($code));

        return true;
    }

    private function check_required_fields($field_type)
    {
        if (empty($field_type)) return false;

        $required_fields = [
            'shipper' => [
                'mondial_relay_shipper_civility',
                'mondial_relay_shipper_name',
                'mondial_relay_shipper_name_2',
                'mondial_relay_shipper_address_1',
                'mondial_relay_shipper_zip_code',
                'mondial_relay_shipper_city',
                'mondial_relay_shipper_country',
            ],
            'account' => [
                'mondial_relay_customer_code',
                'mondial_relay_private_key',
            ],
        ];


        $missing_fields = [];

        foreach ($required_fields[$field_type] as $one_required_field) {
            if ( empty( $this->configs[$one_required_field] ) ) {
                $missing_fields[] = $one_required_field;
            }
        }

        return $missing_fields;
    }


    public function registerParcelsFromOrder() {

		if ( ! $this->order ) {
			return false;
		}

		$whitelist = [ "DE", "BE", "ES", "FR", "IT", "LU", "PT", "GB", "IE", "NL", "AT" ];

		if ( ! in_array( 'FR', $whitelist ) ) {
			return false;
		}

		$result = $this->buildOutcomePayload();
      
		if ( empty( $result ) ) {
			dd($this->errors);
		}

		$api_result = $this->registerParcels( $result );
        
		if ( $api_result->STAT !== '0' ) {
			if ( 92 == $api_result->STAT ) {
				$this->errors[] = sprintf(
                    'Error while registering parcels for order => You don\'t have enough credits to generate a shipping label. You need to refill your account from this page : %s',
                    '<a href="https://www.mondialrelay.fr/mon-profil-mondial-relay/compte-prepaye/" target="_blank">https://www.mondialrelay.fr/mon-profil-mondial-relay/compte-prepaye/</a>'
                );
				return false;
			}
        
			$this->errors[] = sprintf( 
                'Error while registering parcels for order => %s',
                $this->getErrorMessages( $api_result->STAT )
            );

		}

        if ( ! empty( $this->errors ) ) {
            dd($this->errors);
        }

        //Save the information after checking

		return true;
	}

    public function settings(): array
    {
        return [
            array(
                'label'         => trans("method_name"),
                'type'          => 'repeater',
                'name'          => "account_information",
                'class'         => 'form-control form-input m-b-5',
                'col'           => 'col-md-12',
                'inputs'        => [
                    array(
                        'type' => 'text',
                        'name' => 'account_number' 
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'account_label' 
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'subaccount_number' 
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'password' 
                    ),
                ],
            )
        ];
    }
}