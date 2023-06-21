<?php

namespace Timuchen\ShoppingCart\Traits;

trait Purchaser
{
    /**
     * Get the identifier for this purchaseable item.
     *
     * @return mixed
     */
    public function getIdentifier() : mixed
    {
        return method_exists($this, 'getKey') ? $this->getKey() : $this->id;
    }

    /**
     * Determine the underlying type of this purchaseable type.
     *
     * @return string
     */
    public function getType() : string
    {
        if (!method_exists($this, 'getMorphClass')) {
            return '';
        }

        return $this->getMorphClass();
    }
}
