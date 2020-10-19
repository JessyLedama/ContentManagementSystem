<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Auth;
use App\Review;

class ProductController extends Controller
{
    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'review']);
    }

    /**
     * Save product to customer likes.
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function like(Request $request)
    {
        Auth::user()->likes()->attach($request->get('id'));
    }

    /**
     * Remove product from customer likes.
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function unlike(Request $request)
    {
        Auth::user()->likes()->detach($request->get('id'));
    }

    /**
     * Save product review.
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function review(Request $request)
    {
        $review = Review::create($request->all());

        return (string) $review;
    }

    /**
     * View product.
     * 
     * @param  string  $slug
     */
    public function show($slug)
    {
        $product = Product::whereSlug($slug)->with(['reviews', 'subCategory.category.products' => function ($query) use ($slug) {

            $query->where('products.slug', '!=', $slug)->take(5);

        }, 'seo'])->first();

        return view('customer.product', compact('product'));
    }
}
