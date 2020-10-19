<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['productId', 'rating', 'title', 'name', 'comment', 'recommend'];

    protected $appends = ['posted'];

    public function getPostedAttribute()
    {
        return $this->created_at->format('F j, Y');
    }
}
