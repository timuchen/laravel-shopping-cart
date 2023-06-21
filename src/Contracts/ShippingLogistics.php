<?php

namespace Timuchen\ShoppingCart;

use Timuchen\ShoppingCart\Checkout;

interface ShippingLogistics
{
    public static function getShippingCost(Checkout $checkout) : float;
}
