<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = ['name', 'slug', 'phone_number', 'cover', 'subcategoryId',];

    protected $appends = ['totalLikes', 'customerFavourite', 'coverUrl', 'url', 'images'];

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategoryId');
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'product_likes', 'productId', 'customerId');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'productId');
    }

    public function getTotalLikesAttribute()
    {
        return count($this->likes);
    }

    public function getCustomerFavouriteAttribute()
    {
        return Auth::check() ? $this->likes->contains(Auth::user()) : false;
    }

    public function getCoverUrlAttribute()
    {
        return Storage::url('products/cover.jpg'); // Storage::url(str_replace('public/uploads/', '', $this->cover));
    }

    public function getUrlAttribute()
    {
        return route('product.page', $this->slug ?? Str::slug($this->name));
    }

    public function getImagesAttribute()
    {
        $gallery = $this->gallery ? explode('|', $this->gallery) : [];

        return $gallery ?  array_map(function ($path, $key) { 

            return [

                'id' => $key,
                'url' => Storage::url(str_replace('public/uploads/', '', $path))
            ]; 

        }, $gallery, array_keys($gallery)) : [];
    }
}
