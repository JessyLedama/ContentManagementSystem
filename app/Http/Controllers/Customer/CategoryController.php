<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;

class CategoryController extends Controller
{
    private $products;

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($slug, Request $request)
    {
        $category = Category::whereSlug($slug)->with('subcategories')->first();

        $products = $this->orderProducts($category->products(), $request->query('order'));

        $products = $this->filterByMaxPrice(
            
            $this->filterByMinPrice(
                
                $products, $request->query('minPrice')
            ),

            $request->query('maxPrice')

        );

        if (!$request->ajax()) $count = $products->count();
        
        $products = $products->paginate(20)->appends([

            'minPrice' => $request->query('minPrice'),
            'maxPrice' => $request->query('maxPrice'),
            'order' => $request->query('order')
        ]);

        if ($request->ajax()) return $products->items();

        return view('customer.category', compact('category', 'products', 'count'));
    }

    /**
     * Filter products by subcategory.
     * 
     * @param  array  $products
     * @param  string  $subCategory
     */
    // public function filterBySubCategory($products, $subCategory)
    // {
    //     return $products->whereHas('subCategory', function ($query) use ($subCategory) {

    //         $query->where('slug', 'like', "%$subCategory%");

    //     });
    // }

    /**
     * Filter products with minimum price.
     * 
     * @param  \Illuminate\Database\Eloquent\Relations\HasManyThrough  $products
     * @param  string  $price
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function filterByMinPrice($products, $price)
    {
        return $products->where('price', '>=', intval($price));
    }

    /**
     * Filter products with maximum price.
     * 
     * @param  \Illuminate\Database\Eloquent\Relations\HasManyThrough  $products
     * @param  string  $price
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function filterByMaxPrice($products, $price)
    {
        return $price ? $products->where('price', '<=', intval($price)) : $products;
    }

    /**
     * Order products.
     * 
     * @param  \Illuminate\Database\Eloquent\Relations\HasManyThrough  $products
     * @param  string $order
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function orderProducts($products, $order)
    {
        switch ($order) {
            case 'lowestPrice':

                $products = $products->orderBy('price');
                break;

            case 'highestPrice':
            
                $products = $products->orderBy('price', 'desc');
                break;

            default:
            
                $products = $products->latest();
                break;
        }

        return $products;
    }
}
