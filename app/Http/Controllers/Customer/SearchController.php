<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;

class SearchController extends Controller
{
    /**
     * Filter and display the specified resource.
     *
     * @param  string  $slug
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $term = $request->query('search', '');

        $products = Product::where('name', 'like', "%$term%");

        if (!$request->ajax()) $count = $products->count();

        $products = $products->paginate(20)->appends([

            'search' => $term

        ]);

        if ($request->ajax()) return $products->items();

        return view('customer.search', compact('products', 'count'));
    }
}
