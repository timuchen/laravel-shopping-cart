# Laravel Shopping Cart

A simple yet customizable Laravel shopping cart implementation.

Provides RESTful API endpoints out of the box to help with front-end / SPA integrations.

## Table of Contents

[Requirements](#requirements)  
[Installation](#installation)  
[Usage](#usage)
[The Checkout Class](#the-checkout-class)  
[Customization](#customization)  
[License](#license)

## Requirements

- PHP 8.2
- Laravel 10.x

## Installation

```bash
composer require timuchen/shoping-cart
```

The package publishes some migrations, routes (for optional use) and classes for further customizing your store logistics.

```bash
php artisan vendor:publish --provider="Timuchen\ShoppingCart\ShoppingCartServiceProvider"
```

Full list of published files:

- database/migrations/create_carts_table
- database/migrations/create_cart_items_table
- app/Logistics/CartLogistics.php
- app/Logistics/ShippingLogistics.php
- app/Logistics/TaxLogistics.php
- app/Logistics/DiscountLogistics.php

## Usage

First, simply implement the _Purchaseable_ interface on your product (or other purchaseable) model.

**app/Models/Product.php**

```php
use Timuchen\ShoppingCart\Traits\Purchaseable;
use Timuchen\ShoppingCart\Contracts\Purchaseable as PurchaseableInterface;

class Product extends Model implements PurchaseableInterface
{
    use Purchaseable;
}
```

Next we should implement the _Purchaser_ interface on the model representing the end customer.

**app/Models/Customer.php**

```php
use Timuchen\ShoppingCart\Traits\Purchaser;
use Timuchen\ShoppingCart\Contracts\Purchaser as PurchaserInterface;

class Customer extends Model implements PurchaserInterface
{
    use Purchaser;
}
```

If you would like to use the built-in cart API endpoints, you can simply include the published _checkout.php_ in your existing routes file.

**routes/api.php** (optional)

```php
Route::group(['middleware' => ['example']], function () {
    require base_path('routes/checkout.php');
});
```

## The Checkout Class

The package comes with a _Checkout_ class which allows you to interact with the shopping cart.

```php
use Timuchen\ShoppingCart\Checkout;
```

Creating or retrieving a checkout instance:

```php
$checkout = Checkout::create();
// or
$checkout = Checkout::findById('uuid-123');
```

Getting the ID of an existing checkout:

```php
$checkout->id();
```

Adding a custom field for a checkout:

```php
$checkout->setCustomField('some key', 'some value');
```

Deleting a checkout:

```php
$checkout->destroy();
```

Interacting with the underlying cart model and query builder:

```php
// Yab\ShoppingCart\Models\Cart
$checkout->getCart();

// Illuminate\Database\Eloquent\Builder
$checkout->getCartBuilder();
```

Adding, updating or removing cart items:

```php
// Add 1 qty of product and return the CartItem model
$item = $checkout->addItem($product, 1);

// Override the default unit price for the product
$item = $checkout->addItem($product, 1, 11.95);

// Add custom options to a checkout item
$item = $checkout->addItem(
    purchaseable: $product,
    qty: 1,
    options: [ 'size' => 'medium' ],
);

// Update the quantity of the item to 2
$checkout->updateItem($item->id, 2);

// Remove the item entirely
$checkout->removeItem($item->id);
```

Optionally set a purchaser entity (class must implement Purchaser interface):

```php
$checkout->setPurchaser($customer);
```

Getting the shipping, subtotal, taxes and total:

```php
$checkout->getShipping(); // 5.00
$checkout->getSubtotal(); // 110.00
$checkout->getDiscount(); // 10.00
$checkout->getTaxes(); // 13.00
$checkout->getTotal(); // 113.00
```

## Customization

Not every e-commerce store is the same. This package provides several "logistics" classes which allow you to hook into the core package logic and perform some common customizations. For example, you may specify how the tax, shipping and discount amounts are determined:

**app/Logistics/TaxLogistics.php**

```php
public static function getTaxes(Checkout $checkout) : float
```

**app/Logistics/ShippingLogistics.php**

```php
public static function getShippingCost(Checkout $checkout) : float
```

**app/Logistics/DiscountLogistics.php**

```php
public static function getDiscountFromCode(Checkout $checkout, string $code) : float
```

**app/Logistics/CartLogistics.php**

```php
public static function getPurchaseable(string $type, mixed $id) : mixed
public static function beforeCartItemAdded(Checkout $checkout, mixed $purchaseable, int $qty) : void
public static function hasInfoNeededToCalculateTotal(Checkout $checkout) : bool
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
