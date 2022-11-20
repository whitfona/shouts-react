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
//        $this->call([
//           ProductionCategories::class,
//           ProductionBeers::class,
//            ProductionUsers::class
//        ]);
        User::factory()->create([
            'name' => 'Nick',
            'email' => 'whitford_4@hotmail.com',
            'password' => Hash::make('password'),
            'profile_image' => 'http://localhost:8000/storage/users/man1.png'
        ]);
        User::factory()->create([
            'name' => 'Jill',
            'email' => 'jill@example.com',
            'password' => Hash::make('password'),
            'profile_image' => 'http://localhost:8000/storage/users/girl1.png'
        ]);
        User::factory()->create(['profile_image' => 'http://localhost:8000/storage/users/man2.png']);
        User::factory()->create(['profile_image' => 'http://localhost:8000/storage/users/girl2.png']);

        Category::factory()->create([
            'type' => 'ale'
        ]);
        Category::factory()->create([
            'type' => 'IPA'
        ]);
        Category::factory()->create([
            'type' => 'sour'
        ]);

        Beer::factory()->create([
            'barcode' => 839561000002,
            'name' => 'Elora Borealis',
            'brewery' => 'Elora Brewing Co.',
            'alcohol_percent' => 5.1,
            'has_lactose' => true,
            'category_id' => Category::find(1)->id,
            'photo' => "elora.png"
        ]);
        Beer::factory()->create([
            'barcode' => 628028020468,
            'name' => 'Papays Juicy IPA',
            'brewery' => 'Cowbell Brewing Co.',
            'alcohol_percent' => 6,
            'has_lactose' => false,
            'category_id' => Category::find(2)->id,
            'photo' => "papaya.png"
        ]);
        Beer::factory()->create([
            'barcode' => null,
            'name' => 'Beki',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 4.8,
            'has_lactose' => false,
            'category_id' => Category::find(3)->id,
            'photo' => "beki.png"
        ]);
        Beer::factory()->create([
            'barcode' => 818278002240,
            'name' => 'Electric Unicorn',
            'brewery' => 'Phillips Brewing & Malting Co.',
            'alcohol_percent' => 6.5,
            'has_lactose' => false,
            'category_id' => Category::find(2)->id,
            'photo' => "electric.png"
        ]);
        Beer::factory()->create([
            'barcode' => 626824190040,
            'name' => 'Neon Haze',
            'brewery' => 'Amsterdam Brewing',
            'alcohol_percent' => 5.7,
            'has_lactose' => false,
            'category_id' => Category::find(2)->id,
            'photo' => "neon.png"
        ]);
        Beer::factory()->create([
            'barcode' => null,
            'name' => 'Light Work',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 4.1,
            'has_lactose' => false,
            'category_id' => Category::find(1)->id,
            'photo' => "lightwork.png"
        ]);

        Rating::factory()->create([
            'user_id' => User::find(1)->id,
            'beer_id' => Beer::find(1)->id,
            'rating' => 8,
            'comment' => 'This is quite lovely, I would love to have another!'
        ]);
        Rating::factory()->create([
            'user_id' => User::find(2)->id,
            'beer_id' => Beer::find(2)->id,
            'rating' => 2,
            'comment' => 'I hate everything about this'
        ]);
        Rating::factory()->create([
            'user_id' => User::find(2)->id,
            'beer_id' => Beer::find(3)->id,
            'rating' => 9,
            'comment' => 'This is my favourite beer!!'
        ]);
        Rating::factory()->create([
            'user_id' => User::find(3)->id,
            'beer_id' => Beer::find(1)->id
        ]);
        Rating::factory()->create([
            'user_id' => User::find(1)->id,
            'beer_id' => Beer::find(3)->id
        ]);
        Rating::factory()->create([
            'user_id' => User::find(1)->id,
            'beer_id' => Beer::find(4)->id
        ]);
        Rating::factory()->create([
            'user_id' => User::find(3)->id,
            'beer_id' => Beer::find(3)->id
        ]);
        Rating::factory()->create([
            'user_id' => User::find(3)->id,
            'beer_id' => Beer::find(4)->id
        ]);
        Rating::factory()->create([
            'user_id' => User::find(4)->id,
            'beer_id' => Beer::find(1)->id
        ]);
        Rating::factory()->create([
            'user_id' => User::find(4)->id,
            'beer_id' => Beer::find(2)->id
        ]);
        Rating::factory()->create([
            'user_id' => User::find(4)->id,
            'beer_id' => Beer::find(4)->id
        ]);
        Rating::factory()->create([
            'user_id' => User::find(1)->id,
            'beer_id' => Beer::find(5)->id
        ]);
        Rating::factory()->create([
            'user_id' => User::find(4)->id,
            'beer_id' => Beer::find(6)->id
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
