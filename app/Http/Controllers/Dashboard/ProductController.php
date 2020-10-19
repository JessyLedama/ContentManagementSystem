<?php

namespace App\Http\Controllers\Dashboard;

use App\Product;
use App\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);
        $count = count(Product::all());

        return view('dashboard.product.index', compact('products','count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subCategories = SubCategory::has('category')->with('category')->get();

        return view('dashboard.product.create', compact('subCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cover = $request->file('cover')->store('products');

        $gallery = [] + array_map(function ($image) {

            return $image->store('products');

        }, $request->file('gallery') ?? []);

        $product = Product::create($request->except(['cover', 'gallery', 'featured']) + [

            'cover' => $cover,
            'gallery' => implode('|', $gallery),
            'featured' => $request->featured ?? false
        ]);

        $product->seo()->create([

            'title' => $request->seo_title ?? '',
            'keywords' => $request->seo_keywords ?? '',
            'description' => $request->seo_description ?? ''
        ]);

        session()->flash('success', 'Member has been added.');

        return redirect()->route('product.index', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $subCategories = SubCategory::has('category')->with('category')->get();

        return view('dashboard.product.edit', compact('subCategories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($request->hasFile('cover')) {

            Storage::delete(str_replace('public/uploads/', '', $product->cover));

            $cover = $request->file('cover')->store('products');
        }

        $gallery = explode('|', trim($product->gallery)) + array_map(function ($image) {

            return $image->store('products');

        }, $request->file('gallery') ?? []);

        $product->update($request->except(['cover', 'gallery', 'featured']) + [

            'cover' => $cover ?? $product->cover,
            'gallery' => implode('|', $gallery),
            'featured' => $request->featured ?? false
        ]);

        $product->seo()->updateOrCreate([

            'seoable_id' => $product->id,
            'seoable_type' => get_class($product)
        ], [

            'title' => $request->seo_title ?? '',
            'keywords' => $request->seo_keywords ?? '',
            'description' => $request->seo_description ?? ''
        ]);

        session()->flash('success', 'Member details have been updated.');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        session()->flash('success', 'Member has been deleted.');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroyInGallery(Request $request, Product $product)
    {
        $index = $request->index;
        
        $gallery = explode('|', $product->gallery);
        
        if (Storage::delete(str_replace('public/uploads/', '', $gallery[$index]))) {

            unset($gallery[$index]);

            $product->update([

                'gallery' => implode('|', $gallery)
            ]);
        }
        else return response('Failed to delete remove from gallery', 500);
    }
}
