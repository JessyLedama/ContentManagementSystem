<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use App\SubCategory;
use App\User;

class HomeController extends Controller
{
    public function home()
    {
        $categories = Category::all()->each(function ($category) {

            $category->load(['products' => function ($query) {

                $query->inRandomOrder()->limit(5);
    
            }]);
            
        });

        $featuredProducts = Product::whereFeatured(true)->inRandomOrder()->take(5)->get();

        $subcategories = SubCategory::all();

        $members = User::all();

        return view('customer.welcome', compact('categories', 'featuredProducts','subcategories', 'members'));
    }
}
