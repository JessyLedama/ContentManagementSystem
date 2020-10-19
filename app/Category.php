<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'cover', 'description'];

    protected $appends = ['url'];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class, 'categoryId');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, SubCategory::class, 'categoryId', 'subcategoryId');
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function getUrlAttribute()
    {
        return route('category.page', $this->slug);
    }
}
