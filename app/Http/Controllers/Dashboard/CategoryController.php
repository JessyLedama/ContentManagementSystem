<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view('dashboard.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->all());

        $category->seo()->create([
            
            'title' => $request->seo_title ?? '',
            'keywords' => $request->seo_keywords ?? '',
            'description' => $request->seo_description ?? ''
        ]);

        session()->flash('success', 'Category has been saved.');

        return redirect()->route('category.index', $category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $category->load('seo');
        
        return view('dashboard.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->all());

        $category->seo()->updateOrCreate([

            'seoable_id' => $category->id,
            'seoable_type' => get_class($category)
        ], [

            'title' => $request->seo_title ?? '',
            'keywords' => $request->seo_keywords ?? '',
            'description' => $request->seo_description ?? ''
        ]);

        session()->flash('success', 'Category has been updated.');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  var  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($category)
    {
        DB::table('categories')->delete($category);

        session()->flash('success', 'Category has been deleted.');

        return back();
    }
}
