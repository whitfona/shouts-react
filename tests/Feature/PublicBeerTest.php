<?php

namespace Tests\Feature;

use App\Http\Resources\BeerResource;
use App\Models\Beer;
use App\Models\Category;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PublicBeerTest extends TestCase
{

    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

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
        User::factory(2)->create();

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
            'has_lactose' => false,
            'category_id' => Category::find(1)->id
        ]);
        Beer::factory()->create([
            'barcode' => 628028020468,
            'name' => 'Papays Juicy IPA',
            'brewery' => 'Cowbell Brewing Co.',
            'alcohol_percent' => 6,
            'has_lactose' => false,
            'category_id' => Category::find(2)->id
        ]);
        Beer::factory()->create([
            'barcode' => null,
            'name' => 'Beki',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 4.8,
            'has_lactose' => false,
            'category_id' => Category::find(3)->id
        ]);
        Beer::factory()->create([
            'barcode' => 818278002240,
            'name' => 'Electric Unicorn',
            'brewery' => 'Phillips Brewing & Malting Co.',
            'alcohol_percent' => 6.5,
            'has_lactose' => false,
            'category_id' => Category::find(2)->id
        ]);
        Beer::factory()->create([
            'barcode' => 626824190040,
            'name' => 'Neon Haze',
            'brewery' => 'Amsterdam Brewing',
            'alcohol_percent' => 5.7,
            'has_lactose' => false,
            'category_id' => Category::find(2)->id
        ]);
        Beer::factory()->create([
            'barcode' => null,
            'name' => 'Light Work',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 4.1,
            'has_lactose' => false,
            'category_id' => Category::find(1)->id
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

    }

    public function test_get_all_beers_with_all_ratings_comments_from_all_users_and_category()
    {
        $beers = Beer::all();

        $this->getJson(route('beers.index'))
            ->assertOk()
            ->assertJson($beers->toArray());
    }

    public function test_use_barcode_to_get_single_beer_with_all_ratings_comments_from_all_users()
    {
        $beer = Beer::find(2);
        $beerResource = new BeerResource($beer);

        $this->getJson(route('beers.barcode.show', $beer->barcode))
            ->assertOk()
            ->assertJson([$beerResource]);
    }

    public function test_return_all_beers_from_same_brewery()
    {
        $beer = Beer::find(3);

        $this->getJson(route('beers.brewery.show', $beer->brewery))
            ->assertOk()
            ->assertJsonCount(2);
    }

    public function test_return_all_beers_from_same_category()
    {
        $beer = Beer::find(2);
        $result = Beer::all()->where('category', '=', $beer->category);

        $this->getJson(route('beers.category.show', $beer->category))
            ->assertOk()
            ->assertJsonCount($result->count());
    }

    public function test_return_all_beers_for_a_user()
    {
        $user = User::find(1);
        $result = Rating::all()->where('user_id', '=', $user->id);

        $this->get(route('beers.user.show', $user->id))
            ->assertOk()
            ->assertJsonCount($result->count());
    }


    public function test_return_all_categories()
    {
        $categories = Category::all();

        $this->getJson(route('categories.index'))
            ->assertOk()
            ->assertJson($categories->toArray());
    }

    public function test_return_beer_when_searching_title()
    {
        $beer = Beer::find(1);

        $this->getJson(route('beers.search.show', $beer->name))
            ->assertOk()
            ->assertJsonCount(1);
//            ->assertJson($beer->toArray());

        $this->getJson(route('beers.search.show', $beer->brewery))
            ->assertOk()
            ->assertJsonCount(1);
//            ->assertJson($beer->toArray());
    }
}
