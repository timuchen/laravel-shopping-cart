<?php

namespace Timuchen\ShoppingCart\Models;

use Timuchen\ShoppingCart\Casts\Money;
use Timuchen\ShoppingCart\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'purchaseable_id',
        'purchaseable_type',
        'qty',
        'custom_fields',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'qty' => 'integer',
        'unit_price' => Money::class,
        'price' => Money::class,
        'custom_fields' => 'array',
    ];

    /**
     * A cart item belongs to a cart.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart() : BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * The actual item (e.g. product) that was purchased.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function purchaseable() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Set the quantity for this item.
     *
     * @param integer $qty
     *
     * @return \Yab\ShoppingCart\Models\CartItem
     */
    public function setQty(int $qty) : CartItem
    {
        $this->qty = $qty;

        return $this;
    }

    /**
     * Set the custom options for this item
     *
     * @param array $options
     *
     * @return \Yab\ShoppingCart\Models\CartItem
     */
    public function setOptions(array $options) : CartItem
    {
        $custom = $this->custom_fields;
        $custom['options'] = $options;

        $this->custom_fields = $custom;

        return $this;
    }

    /**
     * Calculate the price for this line item based on the quantity.
     *
     * @param float|null $unitPrice
     *
     * @return \Yab\ShoppingCart\Models\CartItem
     */
    public function calculatePrice(float|null $unitPrice = null) : CartItem
    {
        if (is_null($unitPrice)) {
            $unitPrice = $this->purchaseable->getRetailPrice();
        }

        $this->unit_price = $unitPrice;
        $this->price = $unitPrice * $this->qty;

        return $this;
    }
}
