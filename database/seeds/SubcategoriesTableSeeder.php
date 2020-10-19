<?php

use Illuminate\Database\Seeder;
use App\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // SubCategory::all()->each(function ($subcategory) {

        //     $name = Str::random( random_int(3, 5) );

        //     $subcategory->update([

        //         'name' => $name,
        //         'slug' => Str::slug($name)
        //     ]);
        // });

        DB::table('subcategories')->whereNotIn('categoryId', [1,2,3,4,5])->update([

            'categoryId' => 12
        ]);
    }
}
