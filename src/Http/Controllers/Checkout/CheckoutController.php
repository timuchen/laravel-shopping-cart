<?php

namespace Timuchen\ShoppingCart\Http\Controllers\Checkout;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Timuchen\ShoppingCart\Checkout;
use Timuchen\ShoppingCart\Http\Controllers\Controller;
use Timuchen\ShoppingCart\Http\Resources\CheckoutResource;
use Timuchen\ShoppingCart\Http\Requests\CheckoutUpdateRequest;

class CheckoutController extends Controller
{
    /**
     * Create a new cart instance.
     *
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $checkout = Checkout::create();

        return new CheckoutResource($checkout);
    }

    /**
     * Fetch the details for a particular checkout ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $checkoutId
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, string $checkoutId)
    {
        $checkout = Checkout::findById($checkoutId);

        return new CheckoutResource($checkout);
    }

    /**
     * Update the details for a particular checkout ID.
     *
     * @param  \Timuchen\ShoppingCart\Http\Requests\CheckoutUpdateRequest  $request
     * @param  string $checkoutId
     *
     * @return \Illuminate\Http\Response
     */
    public function update(CheckoutUpdateRequest $request, string $checkoutId)
    {
        $checkout = Checkout::findById($checkoutId);

        if ($request->custom_fields) {
            foreach ($request->custom_fields as $key => $value) {
                $checkout->setCustomField($key, $value);
            }
        }

        return new CheckoutResource($checkout);
    }

    /**
     * Delete the contents for a particular checkout ID.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $checkoutId
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, string $checkoutId)
    {
        $checkout = Checkout::findById($checkoutId);

        $checkout->destroy();

        return response()->make('', Response::HTTP_NO_CONTENT);
    }
}
