<?php

use Illuminate\Database\Seeder;
use App\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Carpets & Mats', 'Bedroom', 'Curtains & Accessories', 'Furniture', 'Pillows'];

        array_map(function ($category, $name) {

            DB::table('categories')->where('id', $category['id'])->update([

                'name' => $name,
                'slug' => Str::slug($name)
            ]);
            
        }, Category::take(5)->get()->toArray(), $categories);

        DB::table('categories')->whereNotIn('name', $categories)->delete();
    }
}
