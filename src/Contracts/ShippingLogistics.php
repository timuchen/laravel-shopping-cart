<?php

namespace Timuchen\ShoppingCart\Contracts;

use Timuchen\ShoppingCart\Checkout;

interface ShippingLogistics
{
    public static function getShippingCost(Checkout $checkout) : float;
}
