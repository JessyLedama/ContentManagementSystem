<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['name', 'slug', 'cover', 'description', 'categoryId'];

    protected $appends = ['url'];

    protected $table = 'subcategories';

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId');
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'subcategoryId');
    }

    public function getUrlAttribute()
    {
        return route('subcategory.page', $this->slug);
    }
}
