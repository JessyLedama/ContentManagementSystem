<?php

namespace App\Http\Controllers\Dashboard;

use App\SubCategory;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use DB;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subCategories = SubCategory::has('category')->with('category')->latest()->paginate(10);

        return view('dashboard.subcategory.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('dashboard.subcategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubCategoryRequest $request)
    {
        $subCategory = SubCategory::create($request->all());

        $subCategory->seo()->create([

            'title' => $request->seo_title ?? '',
            'keywords' => $request->seo_keywords ?? '',
            'description' => $request->seo_description ?? '',
            'seoable_id' => $subCategory->id,
            'seoable_type' => get_class($subCategory)
        ]);

        session()->flash('success', 'Subcategory has been saved.');

        return redirect()->route('subcategory.edit', $subCategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        $subCategory->load('seo');

        $categories = Category::all();

        return view('dashboard.subcategory.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubCategoryRequest  $request
     * @param  \App\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubCategoryRequest $request, SubCategory $subCategory)
    {
        $subCategory->update($request->all());

        $subCategory->seo()->updateOrCreate([

            'seoable_id' => $subCategory->id,
            'seoable_type' => get_class($subCategory)
        ], [
            
            'title' => $request->seo_title ?? '',
            'keywords' => $request->seo_keywords ?? '',
            'description' => $request->seo_description ?? ''
        ]);

        session()->flash('success', 'Subcategory has been updated.');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  var  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($subCategory)
    {
        DB::table('subcategories')->delete($subCategory);

        session()->flash('success', 'Subcategory has been deleted.');

        return back();
    }
}
