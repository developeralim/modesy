<?php

namespace App\Services\Shippings\Traits\Chronopost;

use App\Services\Shippings\Helpers\ChronopostUtility;
use DateTime;
use Exception;
use SoapClient;
use SoapFault;

trait WebService
{
    const CHRONOPOST_REVERSE_R = '4R';

    // for Chronopost Reverse 9
    const CHRONOPOST_REVERSE_S = '4S';

    // for Chronopost Reverse 10
    const CHRONOPOST_REVERSE_T = '4T';

    // for Chronopost Reverse 13
    const CHRONOPOST_REVERSE_U = '4U';

    // for Chronopost Reverse 18
    const CHRONOPOST_REVERSE_DEFAULT = '01';

    // for Chronopost Reverse 18
    const CHRONOPOST_REVERSE_RELAIS_EUROPE = '3T';

    // for Chronopost Reverse RelaisEurope
    const CHRONOPOST_REVERSE_TOSHOP = '5Y';

    // for Chronopost Reverse TOSHOP
    const CHRONOPOST_REVERSE_TOSHOP_EUROPE = '6C'; // for Chronopost Reverse TOSHOP EUROPE

    const CHRONOPOST_REVERSE_R_SERVICE = '885';

    // for Chronopost Reverse 9
    const CHRONOPOST_REVERSE_S_SERVICE = '180';

    // for Chronopost Reverse 10
    const CHRONOPOST_REVERSE_T_SERVICE = '898';

    // for Chronopost Reverse 13
    const CHRONOPOST_REVERSE_U_SERVICE = '835';

    // for Chronopost Reverse 18
    const CHRONOPOST_REVERSE_DEFAULT_SERVICE = '226';

    // for Chronopost Reverse 18
    const CHRONOPOST_REVERSE_RELAY_EUROPE_SERVICE = '332';

    // for Chronopost Reverse RelaisEurope
    const CHRONOPOST_REVERSE_TOSHOP_SERVICE = '1';

    // for Chronopost Reverse Toshop
    const CHRONOPOST_REVERSE_TOSHOP_EUROPE_SERVICE = '332'; // for Chronopost Reverse Toshop Europe

    const CHRONOPOST_EXPRESS = '17';

    protected function checkMobileNumber($value)
	{
		if (( $reqvalue = trim($value)) !== '' && ($reqvalue = trim($value)) !== '0') {
			$_number = substr($reqvalue, 0, 2);
			$fixed_array = array('01', '02', '03', '04', '05', '06', '07');
			if (in_array($_number, $fixed_array)) {
				return $reqvalue;
			}

			return '';
		}
	}
   
    public function saveAndCreateShipmentLabel()
    {
        /** @var \App\Services\Shippings\Interfaces\MethodInterface|null $shipping_method*/
        $shipping_method      = $this->getMethod();
        $shipping_method_id   = $shipping_method?->getName();
        $shippingMethodAllow  = array_keys( $this->methods );
        $shipment_datas       = false;


        if ( $shipping_method && in_array(  $shipping_method->getName(),$shippingMethodAllow ) ) {
            $ref = array();

            // parcels
            $parcels_number = $this->configs['chrono_parcels_number'];

            // Dimensions
            $parcels_dimensions = $this->configs['chrono_parcels_dimensions'];

            if ($parcels_dimensions && is_array($parcels_dimensions)) {
                // Check if within boundaries
                $check = ChronopostUtility::chrono_check_packages_dimensions($shipping_method_id, $parcels_dimensions);
           
                if ($check !== true) {
                    $this->errors[] = $check;
                    return false;
                }

            } else {
                $parcels_dimensions = array();
                for ($i = 1; $i <= $parcels_number; ++$i) {
                    $parcels_dimensions[$i] = array(
                        'weight' => self::getTotalWeight(),
                        'length' => 1,
                        'height' => 1,
                        'width'  => 1,
                    );
                }
            }

            //header parameters
            $contract = $this->getContractInfo();

            if (! $contract) {

                $this->errors[] = sprintf('
                    Configuration error:The contract can\'t be found for this order. You can check the carrier configuration to fix this issue.
                ');
                
                return false;
            }

            $header = array(
                'idEmit'        => 'MODESY',
                'accountNumber' => $contract['accountNumber'],
                'subAccount'    => $contract['subAccountNumber'],
            );

            $this->withShipper();
            $this->withCustomer();
            $this->withRecipient();

            //ref parameters
            $recipientRef = false;

            // if ($pickup_relay_datas = $_order->get_meta('_shipping_method_chronorelais', true)) {
            //     $recipientRef = $pickup_relay_datas['id'];
            // }

            if ( ! $recipientRef) {
                $recipientRef = $this->buyer->id;
            }

            $shipperRef = $this->order->id;

            for ($i = 1; $i <= $parcels_number; ++$i) {
                $ref[] = array(
                    'recipientRef' => $recipientRef,
                    'shipperRef'   => $shipperRef,
                );
            }

            //skybill parameters
            // Livraison Samedi (Delivery Saturday) field
            $SaturdayShipping    = 0; //default value for the saturday shipping

            $sat_shipMethodAllow = array_diff(
                $shippingMethodAllow,
                array(
                    'chronorelaiseurope',
                    'chronotoshopeurope',
                    'chronoexpress',
                    'chronoclassic',
                    'chronosameday'
                )
            );

            if ($shipping_method_id === 'chronosameday') {
                $SaturdayShipping = '973';
            }

            if (in_array($shipping_method_id, $sat_shipMethodAllow)) {
                $pm_saturday_shipping       = 'yes';
                $_force_deliver_on_saturday = $pm_saturday_shipping == 'yes';
                $_deliver_on_saturday       = 0;
                $is_sending_day             = ChronopostUtility::chrono_is_sending_day();

                if ($pm_saturday_shipping === 'no' && $shipping_method_id !== 'chronosameday') {
                    $SaturdayShipping = 0;
                } elseif ($shipping_method_id === 'chronotoshopdirect') {
                    $SaturdayShipping = 6;
                } elseif (
                    $_force_deliver_on_saturday ||
                    ($_deliver_on_saturday && $is_sending_day)
                ) {
                    // Code différent si Chrono Relai Dom
                    if ($shipping_method_id === 'chronorelaisdom') {
                        $SaturdayShipping = 369;
                    } elseif ($shipping_method_id == 'chronosameday') {
                        $SaturdayShipping = '974';
                    } else {
                        $SaturdayShipping = 6;
                    }
                } elseif (! ($_deliver_on_saturday && $is_sending_day) && $shipping_method_id !== 'chronosameday') {
                    $SaturdayShipping = 1;
                    if ($shipping_method_id === 'chronorelaisdom') {
                        $SaturdayShipping = 368;
                    }
                }
            }

            $weight = self::getTotalWeight();

            // si chronorelaiseurope : service : 337 si poids < 3kg ou 338 si > 3kg
            if ($shipping_method_id === 'chronorelaiseurope' || $shipping_method_id === 'chronotoshopeurope') {
                $SaturdayShipping = $weight <= 3 ? '337' : '338';
            }

            $adValoremEnabled       = 'no';
            $order_insurance_enable = 'no';

            if ($order_insurance_enable != '') {
                $adValoremEnabled = $order_insurance_enable !== 'no';
            }

            $totalAdValorem = 0;

            if ($order_insurance_enable === 'yes' || $adValoremEnabled) {
                $totalAdValorem = ChronopostUtility::chrono_get_advalorem_amount( $this->order );
            }

            if ($weight > 30) {
                $weight = 0; // On met le poids à 0 car les colis sont pesé sur place
            }

            if ($parcels_dimensions === []) {
                $parcel_weight      = $weight;
                $parcel_height      = 1;
                $parcel_length      = 1;
                $parcel_width       = 1;

                $parcels_dimensions = array(
                    1 => array(
                        'weight' => $parcel_weight,
                        'height' => $parcel_height,
                        'length' => $parcel_length,
                        'width'  => $parcel_width,
                    ),
                );
            }

            $skybill = array();

            for ($i = 1; $i <= $parcels_number; ++$i) {

                $parcel_weight = $parcels_dimensions[$i]['weight'];
                $parcel_height = $parcels_dimensions[$i]['height'];
                $parcel_length = $parcels_dimensions[$i]['length'];
                $parcel_width  = $parcels_dimensions[$i]['width'];
                
                $newSkybill    = array(
                    'codCurrency'     => 'EUR',
                    'codValue'        => '',
                    'content1'        => '',
                    'content2'        => '',
                    'content3'        => '',
                    'content4'        => '',
                    'content5'        => '',
                    'customsCurrency' => 'EUR',
                    'customsValue'    => '',
                    'evtCode'         => 'DC',
                    'objectType'      => 'MAR',
                    'productCode'     => '02',
                    'service'         => $SaturdayShipping,
                    'shipDate'        => date('c'),
                    'shipHour'        => date('H'),
                    'skybillRank'     => $i,
                    'bulkNumber'      => $parcels_number,
                    'weight'          => $parcel_weight,
                    'weightUnit'      => 'KGM',
                    'height'          => $parcel_height,
                    'length'          => $parcel_length,
                    'width'           => $parcel_width,
                );

                if ($adValoremEnabled) {
                    $newSkybill['insuredCurrency'] = 'EUR';
                    $newSkybill['insuredValue']    = (int) $totalAdValorem;
                }

                $skybill[] = $newSkybill;
            }

            $skybillParams = array(
                'mode' => 'PDF',
            );

            $expeditionArray = array_merge($this->payload,[
                'headerValue'        => $header,
                'refValue'           => $ref,
                'skybillValue'       => $skybill,
                'skybillParamsValue' => $skybillParams,
                'password'           => $contract['chrnopostPassword'],
                'numberOfParcel'     => $parcels_number,
            ]);
            

            // si chronopostprecise : ajout parametres supplementaires
            if ($shipping_method_id === 'chronoprecise') {

                $chronopostprecise_creneaux_info = orderMeta($this->order,'_shipping_method_chronoprecise');

                if (is_array($chronopostprecise_creneaux_info) && empty($chronopostprecise_creneaux_info['deliverySlotCode'])) {
                    $chronopostprecise_creneaux_info = array_shift($chronopostprecise_creneaux_info);
                }

                $_dateRdvStart = new DateTime($chronopostprecise_creneaux_info['deliveryDate']);
                $_dateRdvStart->setTime(
                    $chronopostprecise_creneaux_info['startHour'],
                    $chronopostprecise_creneaux_info['startMinutes']
                );

                $_dateRdvEnd = new DateTime($chronopostprecise_creneaux_info['deliveryDate']);
                $_dateRdvEnd->setTime(
                    $chronopostprecise_creneaux_info['endHour'],
                    $chronopostprecise_creneaux_info['endMinutes']
                );

                $scheduledValue = array(
                    'appointmentValue' => array(
                        'timeSlotStartDate'   => $_dateRdvStart->format('Y-m-d') . 'T' . $_dateRdvStart->format('H:i:s'),
                        'timeSlotEndDate'     => $_dateRdvEnd->format('Y-m-d') . 'T' . $_dateRdvEnd->format('H:i:s'),
                        'timeSlotTariffLevel' => $chronopostprecise_creneaux_info['tariffLevel'],
                    ),
                );

                $expeditionArray['scheduledValue'] = $scheduledValue;

                foreach ($expeditionArray['skybillValue'] as &$skybillValue) {
                    $skybillValue['productCode'] = $chronopostprecise_creneaux_info['productCode'];
                    $skybillValue['service']     = $chronopostprecise_creneaux_info['serviceCode'];
                    if (isset($chronopostprecise_creneaux_info['asCode'])) {
                        $skybillValue['as'] = $chronopostprecise_creneaux_info['asCode'];
                    }
                }
            }

            try {
               
                $client = new SoapClient( self::API_URL, [
                    'trace'              => true,
                    'cache_wsdl'         => WSDL_CACHE_NONE,
                    'connection_timeout' => 5000,
                    'stream_context'     => stream_context_create([
                        'ssl' => [
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                        ],
                    ])
                ]);

                $expedition  = $client->shippingMultiParcelWithReservationV3($expeditionArray);

                dd($expedition);

                if (! $expedition->return->errorCode && $expedition->return->reservationNumber) {
                    if (isset($expedition->return->resultParcelValue->skybillNumber)) {
                        $expedition->return->resultParcelValue = array($expedition->return->resultParcelValue);
                    }

                    // Save chronopost shipment data in post metas
                    $shipment_datas = WC_Chronopost_Order::add_tracking_numbers(
                        $_order,
                        $expedition->return->resultParcelValue,
                        $expedition->return->reservationNumber
                    );
                    // Save dimensions
                    $shipment_datas = WC_Chronopost_Order::add_parcels_dimensions(
                        $shipment_datas,
                        $parcels_dimensions
                    );
                    // Save skybill params
                    $shipment_datas = WC_Chronopost_Order::add_parcels_skybill_params(
                        $shipment_datas,
                        $expeditionArray
                    );
                    $_order->update_meta_data('_shipment_datas', $shipment_datas);
                    $_order->save();
                } else {

                    switch ($expedition->return->errorCode) {
                        case 33:
                            $shipment_datas = array('error' => 33);
                            break;
                        default:
                            $shipment_datas     = array('error' => -1);
                            $this->admin_notice .= ' ' . __(
                                'Webservice error:',
                                'chronopost'
                            ) . ' ' . $expedition->return->errorMessage;
                            break;
                    }

                    add_action('admin_notices', function () {
                        return $this->print_admin_notice();
                    });
                }
            } catch (SoapFault $fault) {
                $this->errors[] = 'An error occured during the label creation. Please check the customer datas or your Chronopost settings.';
                $this->errors[] = 'System error:' . $fault->getMessage();
            } catch (Exception $fault) {
                $this->errors[] = 'An error occured during the label creation. Please check the customer datas or your Chronopost settings.';
                $this->errors[] = 'System error:' . $fault->getMessage();
            }
        }

        return $shipment_datas;
    }
}
