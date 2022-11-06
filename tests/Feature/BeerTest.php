<?php

namespace Tests\Feature;

use App\Models\Beer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BeerTest extends TestCase
{

    use RefreshDatabase;

    public function test_we_can_get_all_beers()
    {
        $numberOfBeers = 5;
        Beer::factory($numberOfBeers)->create();

        $this->getJson(route('beers.index'))
            ->assertOk()
            ->assertJsonCount($numberOfBeers);
    }


    public function test_get_beers_for_one_user()
    {
        $user = User::factory()->create();

        $userBeers = Beer::factory(2)->create(['user_id' => $user]);
        Beer::factory(2)->create();


        $this->getJson(route('beers.user', $user->id))
            ->assertOk()
            ->assertJsonCount(2)
            ->assertJson($userBeers->toArray());

    }

    public function test_unauthenticated_user_cannot_add_beer()
    {
        $beer = Beer::factory()->make();

        $this->postJson(route('beers.store'), $beer->toArray());

        $this->assertGuest();
    }

    public function test_user_can_add_a_beer()
    {
        $user = User::factory()->create();
        $beer = Beer::factory()->make(['user_id' => $user->id, 'has_lactose' => 'false']);

        $this->actingAs($user)->postJson(route('beers.store'), $beer->toArray())
            ->assertOk();

        $this->assertDatabaseCount('beers', 1);
        $this->assertDatabaseHas('beers', $beer->toArray());
    }
}
