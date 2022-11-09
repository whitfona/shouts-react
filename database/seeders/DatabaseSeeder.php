<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Beer;
use App\Models\Category;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Nick',
            'email' => 'whitford_4@hotmail.com',
            'password' => Hash::make('password'),
        ]);
        User::factory()->create([
            'name' => 'Jill',
            'email' => 'jill@example.com',
            'password' => Hash::make('password'),
        ]);
        User::factory()->create();

        Category::factory()->create([
            'type' => 'ale'
        ]);
        Category::factory()->create([
            'type' => 'IPA'
        ]);

        Beer::factory()->create([
            'barcode' => 839561000002,
            'name' => 'Elora Borealis',
            'brewery' => 'Elora Brewing Co.',
            'alcohol_percent' => 5.1,
            'has_lactose' => false,
            'category_id' => 1
        ]);
        Beer::factory()->create([
            'barcode' => 628028020468,
            'name' => 'Papays Juicy IPA',
            'brewery' => 'Cowbell Brewing Co.',
            'alcohol_percent' => 6,
            'has_lactose' => false,
            'category_id' => 2
        ]);

        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 1,
            'rating' => 8,
            'comment' => 'This is quite lovely, I would love to have another!'
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 2,
            'rating' => 2,
            'comment' => 'I hate everything about this'
        ]);
        Rating::factory()->create([
            'user_id' => 3,
            'beer_id' => 1
        ]);
        Rating::factory()->create([
            'user_id' => 3,
            'beer_id' => 2
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
