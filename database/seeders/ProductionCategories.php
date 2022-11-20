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
        Category::factory()->create(['type' => 'Sour']);
        Category::factory()->create(['type' => 'IPA']);
        Category::factory()->create(['type' => 'Ale']);
        Category::factory()->create(['type' => 'Cider']);
        Category::factory()->create(['type' => 'Lager']);
        Category::factory()->create(['type' => 'Porter']);
        Category::factory()->create(['type' => 'Radler']);
        Category::factory()->create(['type' => 'Stout']);
        Category::factory()->create(['type' => 'Wheat']);
    }
}
