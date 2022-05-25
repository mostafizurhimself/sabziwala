<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $fruit = Category::updateOrCreate(
                ['name' => 'Fruits'],
                [
                    'description' => 'Write you description here'
                ]
            );

            $fruit->addMediaFromUrl(asset('images/categories/fruits.png'))->toMediaCollection('primary');
        });

        DB::transaction(function () {
            $vegetable = Category::updateOrCreate(
                ['name' => 'Vegetables'],
                [
                    'description' => 'Write you description here'
                ]
            );

            $vegetable->addMediaFromUrl(asset('images/categories/vegetables.png'))->toMediaCollection('primary');
        });

        DB::transaction(function () {
            $grocery = Category::updateOrCreate(
                ['name' => 'Groceries'],
                [
                    'description' => 'Write you description here'
                ]
            );

            $grocery->addMediaFromUrl(asset('images/categories/groceries.png'))->toMediaCollection('primary');
        });

        DB::transaction(function () {
            $dairy = Category::updateOrCreate(
                ['name' => 'Dairy'],
                [
                    'description' => 'Write you description here'
                ]
            );

            $dairy->addMediaFromUrl(asset('images/categories/dairy.png'))->toMediaCollection('primary');
        });

        DB::transaction(function () {
            $bakery = Category::updateOrCreate(
                ['name' => 'Bakery'],
                [
                    'description' => 'Write you description here'
                ]
            );

            $bakery->addMediaFromUrl(asset('images/categories/bakery.png'))->toMediaCollection('primary');
        });

        DB::transaction(function () {
            $fish = Category::updateOrCreate(
                ['name' => 'Fish'],
                [
                    'description' => 'Write you description here'
                ]
            );

            $fish->addMediaFromUrl(asset('images/categories/fish.png'))->toMediaCollection('primary');
        });

        DB::transaction(function () {
            $meat = Category::updateOrCreate(
                ['name' => 'Meat'],
                [
                    'description' => 'Write you description here'
                ]
            );

            $meat->addMediaFromUrl(asset('images/categories/meat.png'))->toMediaCollection('primary');
        });

        DB::transaction(function () {
            $beverage = Category::updateOrCreate(
                ['name' => 'Beverage'],
                [
                    'description' => 'Write you description here'
                ]
            );

            $beverage->addMediaFromUrl(asset('images/categories/beverage.png'))->toMediaCollection('primary');
        });
    }
}