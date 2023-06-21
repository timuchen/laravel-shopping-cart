<?php

namespace Timuchen\ShoppingCart\Contracts;

use Timuchen\ShoppingCart\Checkout;

interface CartLogistics
{
    public static function getPurchaseable(string $type, mixed $id) : mixed;
    public static function beforeCartItemAdded(Checkout $checkout, mixed $purchaseable, int $qty) : void;
    public static function hasInfoNeededToCalculateTotal(Checkout $checkout) : bool;
}
