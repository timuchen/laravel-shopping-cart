<?php

namespace Timuchen\ShoppingCart\Http\Controllers\Checkout;

use Timuchen\ShoppingCart\Checkout;
use Timuchen\ShoppingCart\Http\Controllers\Controller;
use Timuchen\ShoppingCart\Http\Resources\CheckoutResource;
use Timuchen\ShoppingCart\Http\Requests\CheckoutDiscountRequest;

class CheckoutDiscountController extends Controller
{
    /**
     * Apply a discount code to a checkout.
     *
     * @param  \Yab\ShoppingCart\Http\Requests\CheckoutDiscountRequest  $request
     * @param  string $checkoutId
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutDiscountRequest $request, string $checkoutId)
    {
        $checkout = Checkout::findById($checkoutId);

        $checkout->applyDiscountCode($request->code);

        return new CheckoutResource($checkout);
    }
}
