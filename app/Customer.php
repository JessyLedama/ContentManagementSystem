<?php

namespace App;

trait Customer
{
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlist_products', 'customerId', 'productId');
    }

    public function likes()
    {
        return $this->belongsToMany(Product::class, 'product_likes', 'customerId', 'productId');
    }

    public function addressBook()
    {
        return $this->hasMany(Address::class, 'customerId');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customerId');
    }
}