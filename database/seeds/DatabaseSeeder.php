<?php

use \Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // disabling foreign keys
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');


        \App\Models\User::truncate();
        \App\Models\Category::truncate();
        \App\Models\Product::truncate();
        \App\Models\Transaction::truncate();
        DB::table('category_product')->truncate();

        \App\Models\User::flushEventListeners();
        \App\Models\Category::flushEventListeners();
        \App\Models\Product::flushEventListeners();
        \App\Models\Transaction::flushEventListeners();

        $userQuantity = 1000;
        $categoriesQuantity = 30;
        $productsQuantity = 1000;
        $transactionsQuantity = 1000;

        factory(\App\Models\User::class, $userQuantity)->create();
        factory(\App\Models\Category::class, $categoriesQuantity)->create();
        factory(\App\Models\Product::class, $productsQuantity)->create()->each(
            function ($product){
                $categories = \App\Models\Category::all()->random(mt_rand(1,5))->pluck('id');
                $product->categories()->attach($categories);
            }
        );
        factory(\App\Models\Transaction::class, $transactionsQuantity)->create();
    }
}
