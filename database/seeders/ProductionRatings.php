<?php

namespace Database\Seeders;

use App\Models\Rating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionRatings extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 37,
            'rating' => 7,
            'comment' => 'Little citrusy taste'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 38,
            'rating' => 7,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 39,
            'rating' => 7,
            'comment' => 'Nice, not too hoppy'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 40,
            'rating' => 7,
            'comment' => 'West coast IPA, real strong'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 41,
            'rating' => 7,
            'comment' => 'New England IPA Very hoppy, great to have 2-3'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 50,
            'rating' => 6,
            'comment' => 'Good beer, nothing special'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 51,
            'rating' => 6,
            'comment' => 'Hoppy and strong'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 53,
            'rating' => 5,
            'comment' => 'Very average. Smell is a bit off putting but could be a solid patio beer when it\'s hot outside'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 63,
            'rating' => 4,
            'comment' => 'Flavoured strong beer, Not hoppy and slightly sour'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 32,
            'rating' => 8,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 42,
            'rating' => 7,
            'comment' => 'IPA, real hoppy'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 59,
            'rating' => 5,
            'comment' => 'Pretty average'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 24,
            'rating' => 6,
            'comment' => 'Would be nice in a patio, similar to Coors Light'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 4,
            'rating' => 6.5,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 2,
            'rating' => 8.1,
            'comment' => 'Very peachy, delicious for 1 or 2'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 21,
            'rating' => 5,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 5,
            'rating' => 6.2,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 20,
            'rating' => 6.8,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 33,
            'rating' => 8,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 46,
            'rating' => 7,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 60,
            'rating' => 5,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 47,
            'rating' => 7,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 6,
            'rating' => 7,
            'comment' => 'Solid'
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 55,
            'rating' => 6,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 56,
            'rating' => 6,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 61,
            'rating' => 5,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 57,
            'rating' => 5,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 62,
            'rating' => 5,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 48,
            'rating' => 7,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 36,
            'rating' => 3,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 1,
            'beer_id' => 49,
            'rating' => 7,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 29,
            'rating' => 9,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 41,
            'rating' => 7,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 52,
            'rating' => 6,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 53,
            'rating' => 6,
            'comment' => 'Fantastic cottage drink... drink in summer sun heat'
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 51,
            'rating' => 5,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 65,
            'rating' => 3,
            'comment' => 'Tastes so light, probably good for summer bbq or after a drunken night'
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 40,
            'rating' => 2,
            'comment' => 'Tastes BITTER'
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 43,
            'rating' => 7,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 24,
            'rating' => 3,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 1,
            'rating' => 7,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 44,
            'rating' => 7,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 34,
            'rating' => 8,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 35,
            'rating' => 8,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 31,
            'rating' => 8.5,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 48,
            'rating' => 7,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 36,
            'rating' => 8,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 4,
            'rating' => 4,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 57,
            'rating' => 6,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 2,
            'beer_id' => 49,
            'rating' => 6,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 3,
            'beer_id' => 58,
            'rating' => 5,
            'comment' => 'Tastes hoppy with a bit of an aftertaste'
        ]);
        Rating::factory()->create([
            'user_id' => 3,
            'beer_id' => 54,
            'rating' => 6,
            'comment' => 'More hoppy than I remembered. I feel like I would actually give it a 5 but I want to like it so I have it a 6. Will return and re-rate when my soul is not hurt from the hops'
        ]);
        Rating::factory()->create([
            'user_id' => 3,
            'beer_id' => 64,
            'rating' => 4,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 3,
            'beer_id' => 26,
            'rating' => 7,
            'comment' => 'Raspberry lemon and yuzu'
        ]);
        Rating::factory()->create([
            'user_id' => 3,
            'beer_id' => 3,
            'rating' => 8.75,
            'comment' => 'Super good, all my friends like it, easy drinking and not hoppy'
        ]);
        Rating::factory()->create([
            'user_id' => 3,
            'beer_id' => 16,
            'rating' => 7.5,
            'comment' => 'Surprisingly good! May rate up if I like it the next time I get it.'
        ]);
        Rating::factory()->create([
            'user_id' => 3,
            'beer_id' => 19,
            'rating' => 6.5,
            'comment' => 'Fine!'
        ]);
        Rating::factory()->create([
            'user_id' => 3,
            'beer_id' => 14,
            'rating' => 7.5,
            'comment' => 'Vanilla which tastes lactose-ey'
        ]);
        Rating::factory()->create([
            'user_id' => 5,
            'beer_id' => 13,
            'rating' => 8.3,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 5,
            'beer_id' => 12,
            'rating' => 8.3,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 5,
            'beer_id' => 45,
            'rating' => 7,
            'comment' => ''
        ]);
        Rating::factory()->create([
            'user_id' => 6,
            'beer_id' => 30,
            'rating' => 9,
            'comment' => 'A nice smooth summery beer. Slight citrus flavour, but not overpowering'
        ]);
        Rating::factory()->create([
            'user_id' => 8,
            'beer_id' => 66,
            'rating' => 2,
            'comment' => 'It\'s Trash'
        ]);
    }
}
