<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::all()->each(function ($product) {

            $name = Str::random( random_int(3, 5) );

            $product->update([

                'name' => $name,
                'slug' => Str::slug($name)
            ]);
        });
    }
}
