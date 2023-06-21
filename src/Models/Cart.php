<?php

namespace Timuchen\ShoppingCart\Models;

use Timuchen\ShoppingCart\Casts\Money;
use Timuchen\ShoppingCart\Traits\UuidModel;
use Timuchen\ShoppingCart\Checkout;
use Timuchen\ShoppingCart\Models\CartItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Cart extends Model
{
    use SoftDeletes, UuidModel;

    /**
     * The name of the primary key field.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Whether or not the primary key should be incremented.
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The primary key type.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The relationships which should be eagerly loaded.
     *
     * @var array
     */
    protected $with = [
        'items',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'discount_amount' => Money::class,
        'custom_fields' => 'array',
    ];

    /**
     * The purchaser entity for this checkout.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function purchaser() : MorphTo
    {
        return $this->morphTo();
    }

    /**
     * A cart may have many line items.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items() : HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Create or retrieve the cart item for the given purchaseable.
     *
     * @param mixed $purchaseable
     *
     * @return \Yab\ShoppingCart\Models\CartItem
     */
    public function getItem(mixed $purchaseable) : CartItem
    {
        return $this->items()->firstOrNew([
            'purchaseable_id' => $purchaseable->getIdentifier(),
            'purchaseable_type' => $purchaseable->getType(),
        ]);
    }

    /**
     * Set a custom field value for this cart.
     *
     * @param string $key
     * @param mixed $payload
     *
     * @return \Yab\ShoppingCart\Models\Cart
     */
    public function setCustomField(string $key, mixed $payload) : Cart
    {
        $custom = $this->custom_fields;
        $custom[$key] = $payload;

        $this->custom_fields = $custom;
        $this->save();

        return $this;
    }
}
