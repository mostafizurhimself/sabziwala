<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::updateOrCreate(
            [
                'name' => 'Fruit'
            ]
        );
        Tag::updateOrCreate(
            [
                'name' => 'Juice'
            ]
        );
        Tag::updateOrCreate(
            [
                'name' => 'Egg'
            ]
        );
        Tag::updateOrCreate(
            [
                'name' => 'Cold Drink'
            ]
        );
        Tag::updateOrCreate(
            [
                'name' => 'Snack'
            ]
        );
        Tag::updateOrCreate(
            [
                'name' => 'Fish'
            ]
        );
        Tag::updateOrCreate(
            [
                'name' => 'Baked'
            ]
        );
        Tag::updateOrCreate(
            [
                'name' => 'Frozen Food'
            ]
        );
        Tag::updateOrCreate(
            [
                'name' => 'Fresh Food'
            ]
        );
        Tag::updateOrCreate(
            [
                'name' => 'Organic Food'
            ]
        );
        Tag::updateOrCreate(
            [
                'name' => 'Flour'
            ]
        );
    }
}