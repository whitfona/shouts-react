<?php

namespace Tests\Feature;

use App\Models\Beer;
use App\Models\Category;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BeerTest extends TestCase
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
//            'category_id' => Category::find(2)->id
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
    }

    public function test_get_all_beers_with_all_ratings_comments_from_all_users_and_category()
    {
        $beers = Beer::all();

        $this->getJson(route('beers.barcode.index'))
            ->assertOk()
            ->assertJson($beers->toArray());
    }

    public function test_use_barcode_to_get_single_beer_with_all_ratings_comments_from_all_users()
    {
        $beer = Beer::find(2);

        $this->getJson(route('beers.barcode.show', $beer->barcode))
            ->assertOk()
            ->assertJson($beer->toArray());
    }

    public function test_get_all_beers_for_logged_in_user()
    {
        $user = User::find(3);
        $numberOfRatings = Rating::all()->where('user_id', '=', $user->id)->count();

        $this->actingAs($user)->getJson(route('beers.user.show', $user))
            ->assertOk()
            ->assertJsonCount($numberOfRatings);
    }

    public function test_cannot_get_beers_for_user_if_not_logged_in()
    {
        $user = User::find(1);

        $this->getJson(route('beers.user.show', $user))
            ->assertUnauthorized();
    }
}
