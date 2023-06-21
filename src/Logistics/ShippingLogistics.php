<?php

namespace App\Logistics;

use Timuchen\ShoppingCart\Checkout;
use Timuchen\ShoppingCart\Contracts\ShippingLogistics as ShippingLogisticsInterface;

class ShippingLogistics implements ShippingLogisticsInterface
{
    /**
     * Get the shipping cost given the checkout instance.
     *
     * @param \Timuchen\ShoppingCart\Checkout $checkout
     *
     * @return float
     */
    public static function getShippingCost(Checkout $checkout) : float
    {
        // Determine the taxes as needed. Possibly helpful methods:

        // $checkout->getCustomField('shipping_address')
        // $checkout->getCart()

        return 0;
    }
}
