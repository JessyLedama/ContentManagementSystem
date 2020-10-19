<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




/**
 * Authentication
 */

Auth::routes();

Route::get('login/facebook', 'Auth\SocialAuthController@redirectToFacebook')->name('login.facebook');

Route::get('auth/callback/facebook', 'Auth\SocialAuthController@handleFacebookCallback');

Route::get('login/google', 'Auth\SocialAuthController@redirectToGoogle')->name('login.google');

Route::get('auth/callback/google', 'Auth\SocialAuthController@handleGoogleCallback');







/**
 * Customer pages
 */

Route::get('/', 'Customer\HomeController@home')->name('home');

Route::get('search', 'Customer\SearchController@search')->name('search');

Route::get('category/{slug}', 'Customer\CategoryController@show')->name('category.page');

Route::get('subcategory/{slug}', 'Customer\SubCategoryController@show')->name('subcategory.page');

Route::view('cart', 'customer.cart')->name('cart.page');

Route::get('cart/products', 'Customer\CartController@products')->name('cart.products');

Route::view('checkout', 'customer.checkout')->name('checkout')->middleware('auth');

Route::resource('order', 'Customer\OrderController')->only(['index', 'store', 'show'])->names([

    'index' => 'customer.order.index',
    'store' => 'customer.order.store',
    'show' => 'customer.order.show'
]);

Route::prefix('product')->group(function () {

    Route::post('like', 'Customer\ProductController@like')->name('product.like');

    Route::delete('unlike', 'Customer\ProductController@unlike')->name('product.unlike');

    Route::post('review', 'Customer\ProductController@review')->name('product.review');

    Route::get('{slug}', 'Customer\ProductController@show')->name('product.page');
});

Route::prefix('account')->group(function () {

    Route::middleware('auth')->group(function () {

        Route::name('customer.profile.')->group(function () {

            Route::get('menu', 'Customer\AccountController@menu')->name('menu');

            Route::get('edit', 'Customer\AccountController@edit')->name('edit');
    
            Route::put('update', 'Customer\AccountController@update')->name('update');
        });

        Route::resource('address-book', 'Customer\AddressController')->except('show')->parameters([

            'address-book' => 'address'
    
        ])->names([
    
            'index' => 'customer.address',
            'create' => 'customer.address.create',
            'store' => 'customer.address.store',
            'edit' => 'customer.address.edit',
            'update' => 'customer.address.update',
            'destroy' => 'customer.address.destroy'
    
        ]);

        Route::resource('order', 'Customer\OrderController')->only([

            'index', 'store', 'show'
    
        ])->names([
    
            'index' => 'customer.order',
            'store' => 'customer.order.store',
            'show' => 'customer.order.show'
    
        ]);

        Route::resource('wishlist', 'Customer\WishlistController')->only([

            'index', 'store', 'destroy'
    
        ])->names([
    
            'index' => 'customer.wishlist',
            'store' => 'customer.wishlist.store',
            'destroy' => 'customer.wishlist.destroy'
    
        ])->parameters([

            'wishlist' => 'id'
        ]);
    });
});








/**
 * Dashboard
 */

Route::prefix('dashboard')->group(function () {

    Route::middleware(['auth', 'dashboard'])->group(function () {

        Route::view('menu', 'dashboard.mobile-menu')->name('dashboard.menu');

        Route::resource('category', 'Dashboard\CategoryController');

        Route::get('/dashboard', 'Dashboard\AccountController@dashboard')->name('dashboard');
    
        Route::resource('subcategory', 'Dashboard\SubCategoryController')->parameters([
            
            'subcategory' => 'subCategory'
        ]);

        Route::delete('product/{product}/delete/gallery', 'Dashboard\ProductController@destroyInGallery')->name('product.destroy.gallery');

        Route::resource('product', 'Dashboard\ProductController');

        Route::resource('order', 'Dashboard\OrderController')->except(['create', 'show', 'store']);

        Route::get('account', 'Dashboard\AccountController@edit')->name('account.edit');

        Route::put('account/update', 'Dashboard\AccountController@update')->name('account.update');
    });
});