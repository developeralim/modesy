<?php

namespace App\Services\Shippings\Traits\Chronopost;

use App\Models\OrderModel;
use App\Services\Shippings\Helpers\ChronopostUtility;

trait Package
{
    public function getTotalWeight($round = false)
    {
        $weight = 0;

        $order_items = (new OrderModel)->getOrderProducts($this->order->id);
       
        foreach ($order_items as $item) {

            $product_id = $item->product_id;

            $product = getActiveProduct( $product_id );
            
            if ( ! $product ) {
                return;
            }

            if ( ! $product->weight ) {
                $this->errors[] = sprintf('Warning, missing weight for Product %s. You should fill this information to make right label estimates.', $product->id);
                continue;
            }

            $itemWeight = $product->weight;

            if ($round) {
                $itemWeight = round($itemWeight);
            }

            $weight += $item->product_quantity * $itemWeight;
        }

        if ( ChronopostUtility::chrono_get_weight_unit()=== 'g' ) {
            $weight /= 1000;
        }

        return $weight;
    }
}