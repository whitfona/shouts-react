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

class PrivateBeerTest extends TestCase
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

    public function test_get_all_beers_for_authenticated_user()
    {
        $user = User::find(1);
        $userBeers = Beer::where('user_id', '=', $user->id);

        $this->actingAs($user)
            ->get(route('beers.user.index'))
            ->dd()
            ->assertOk()
            ->assertJsonCount(4);
//            ->assertJson($userBeers);
    }

    public function test_get_all_beers_by_brewery_for_authenticated_user()
    {
        $user = User::find(1);
        $brewery = 'Elora';

        $this->actingAs($user)
            ->get(route('beers.user.brewery', $brewery))
            ->dd()
            ->assertOk()
            ->assertJsonCount(1);
    }

    public function test_get_all_beers_by_category_for_authenticated_user()
    {
        $user = User::find(1);
        $category = Category::find(1);

        $this->actingAs($user)
            ->get(route('beers.user.category', $category->id))
            ->dd()
            ->assertOk();
//            ->assertJson($category->toArray());
    }

    public function test_get_all_beers_by_search_terms_for_authenticated_user()
    {
        $user = User::find(1);
        $searchTerm = 'Brewing Co';

        $this->actingAs($user)
            ->get(route('beers.user.search', $searchTerm))
            ->dd()
            ->assertOk();
//            ->assertJson($category->toArray());
    }

    public function test_get_beer_using_barcode_scanner_and_user_rating_if_it_exists()
    {
        $user = User::find(1);
        $beer = Beer::find(1);

        $this->actingAs($user)
            ->getJson(route('beers.user.barcode', $beer->barcode))
            ->assertOk();
//            ->assertJson($beer->toArray());
    }

    public function test_add_beer_for_authenticated_user()
    {
        $user = User::find(1);

        $data = [
            'alcohol_percent' => 4.5,
            'barcode' => 628028020468,
            'beer_id' => 1,
            'brewery' => 'Cowbell Brewing Co.',
            'category_id' => 2,
            'comment' => 'This is so good I wish it was real',
            'has_lactose' => false,
            'name' => 'Papays Juicy IPA',
            'photo' => null,
            'rating' => 9
        ];

        $this->actingAs($user)
            ->postJson(route('beers.store'), $data)
            ->assertSuccessful();
    }

    public function test_update_user_profile()
    {
        $user = User::find(1);

        $data = [
            'user_id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@email.com'
        ];

        $this->actingAs($user)
            ->postJson(route('user.store'), $data)
            ->assertOk()
            ->assertRedirect();

    }

    public function test_authenticated_user_can_delete_a_beer()
    {
        $user = User::find(1);
        $rating = Rating::find(1);

        $this->actingAs($user)
            ->delete(route('beers.user.destroy', $rating->id))
            ->assertRedirect(route('dashboard'));
    }
}
