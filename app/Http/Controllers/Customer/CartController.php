<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class CartController extends Controller
{
    /**
     * Load products in shopping cart.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Products[]
     */
    public function products(Request $request)
    {
        $products = Product::whereIn('id', explode(',', $request->query('products')))->get();

        return (string) $products;
    }
}
