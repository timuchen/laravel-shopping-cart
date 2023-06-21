<?php

namespace Timuchen\ShoppingCart\Contracts;

use Timuchen\ShoppingCart\Checkout;

interface TaxLogistics
{
    public static function getTaxes(Checkout $checkout) : float;
}
