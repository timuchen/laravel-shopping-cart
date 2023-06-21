<?php

namespace Timuchen\ShoppingCart\Contracts;

use Timuchen\ShoppingCart\Checkout;

interface DiscountLogistics
{
    public static function getDiscountFromCode(Checkout $checkout, string $code) : float;
}
