<?php
namespace App\Services\Shippings\Helpers;

use App\Models\OrderModel;
use DateTime;

class ChronopostUtility {
    public static $instance = null;

    private function __construct(){}

    private function chrono_check_packages_dimensions( $shipping_method_id, $dimensions ) {

        foreach ( $dimensions as $parcel_dimension ) {
            if ( $shipping_method_id === 'chronorelais' || $shipping_method_id === 'chronorelaiseurope' || $shipping_method_id === 'chronotoshopeurope' || $shipping_method_id === 'chronorelaisdom' ) {
                $max_weight      = 20; // Kg
                $max_size        = 100; // cm
                $max_global_size = 250; //cm
            } else {
                $max_weight      = 30; // Kg
                $max_size        = 150; // cm
                $max_global_size = 300; // cm
            }
    
            if ( $parcel_dimension['weight'] > $max_weight ) {
                return sprintf('One or several packages are above the weight limit (%s kg)', $max_weight );
            }
    
            if ( $parcel_dimension['width'] > $max_size || $parcel_dimension['height'] > $max_size || $parcel_dimension['length'] > $max_size ) {
                return sprintf( 'One or several packages are above the size limit (%s cm)', $max_size );
            }
    
            if ( $parcel_dimension['width'] + ( 2 * $parcel_dimension['height'] ) + ( 2 * $parcel_dimension['length'] ) > $max_global_size ) {
                return sprintf('One or several packages are above the total (L+2H+2l) size limit (%s cm)', $max_global_size );
            }
        }
    
        return true;
    }

    private function chrono_get_weight_unit(): string
    {
        return strtolower('kg');
    }

    private function get_day_with_key( $key ) {
        $days = array(
            'sunday',
            'monday',
            'thuesday',
            'wednesday',
            'thursday',
            'friday',
            'saturday',
        );
        return array_key_exists( $key, $days ) ? $days[ $key ] : 'sunday';
    }

    private function chrono_get_saturday_shipping_days() {
        $startday             = 4;
        $endday               = 5;
        $starttime            = '15:00' ;
        $endtime              = '18:00' ;

        return array(
            'startday'  => $this->get_day_with_key( $startday ),
            'endday'    => $this->get_day_with_key( $endday ),
            'starttime' => $starttime . ':00',
            'endtime'   => $endtime . ':00',
        );
    }
    
    private function chrono_is_sending_day() {
        $satDays = $this->chrono_get_saturday_shipping_days();
    
        $satDayStart  = date( 'N', strtotime( $satDays['startday'] ) );
        $satTimeStart = explode( ':', $satDays['starttime'] );
    
        $endDayStart  = date( 'N', strtotime( $satDays['endday'] ) );
        $endTimeStart = explode( ':', $satDays['endtime'] );
    
        $start = new DateTime( 'last sun' );
        // COMPAT < 5.36 : no chaining (returns null)
        $start->modify( '+' . $satDayStart . ' days' );
        $start->modify( '+' . $satTimeStart[0] . ' hours' );
        $start->modify( '+' . $satTimeStart[1] . ' minutes' );
    
        $end = new DateTime( 'last sun' );
        $end->modify( '+' . $endDayStart . ' days' );
        $end->modify( '+' . $endTimeStart[0] . ' hours' );
        $end->modify( '+' . $endTimeStart[1] . ' minutes' );
    
        if ( $end < $start ) {
            $end->modify( '+1 week' );
        }
    
        $end    = $end->getTimestamp();
        $start  = $start->getTimestamp();
    
        $now    = (new DateTime())->getTimestamp();
        
        return $start <= $now && $now <= $end;
    }

    private function chrono_get_advalorem_amount( $order ) {

        $insurance_amount = (float) 0 * 100;
    
        $totalAdValorem     = 0;
        $maxAmount          = 20000;
        $adValoremAmount    = (float) 0 * 100;
        $orderItems        = (new OrderModel)->getOrderProducts($order->id);

        foreach ( $orderItems as $item) {
            $totalAdValorem += getPrice($item->product_total_price,'database') * 100;
        }
    
        $totalAdValorem = $insurance_amount > 0  ? $insurance_amount : $totalAdValorem;
    
        $totalAdValorem = min($totalAdValorem, $maxAmount);
    
        if ($totalAdValorem < $adValoremAmount) {
            return 0;
        }
    
        return $totalAdValorem;
    }
    

    public static function __callStatic($name, $arguments)
    {
        if ( ! self::$instance ) {
            self::$instance = new static;
        }

        return self::$instance->{$name}( ...$arguments );
    }
}