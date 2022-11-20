<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductionCategories extends Seeder
{
    /**
     * Run the database category seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()->create(['type' => 'Sour']);//1
        Category::factory()->create(['type' => 'IPA']);//2
        Category::factory()->create(['type' => 'Ale']);//3
        Category::factory()->create(['type' => 'Cider']);//4
        Category::factory()->create(['type' => 'Lager']);//5
        Category::factory()->create(['type' => 'Porter']);//6
        Category::factory()->create(['type' => 'Radler']);//7
        Category::factory()->create(['type' => 'Stout']);//8
        Category::factory()->create(['type' => 'Wheat']);//9
    }
}
