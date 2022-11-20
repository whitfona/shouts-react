<?php

namespace Database\Seeders;

use App\Models\Beer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionBeers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => 839561000002,
            'name' => 'Elora Borealis',
            'brewery' => 'Elora Brewing Co.',
            'alcohol_percent' => 5.1,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 2,
            'barcode' => 628028020468,
            'name' => 'Papays Juicy IPA',
            'brewery' => 'Cowbell Brewing Co.',
            'alcohol_percent' => 6,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Beki',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 4.8,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 2,
            'barcode' => 818278002240,
            'name' => 'Electric Unicorn',
            'brewery' => 'Phillips Brewing & Malting Co.',
            'alcohol_percent' => 6.5,
            'has_lactose' => false,
            'photo' => null
        ]);Beer::factory()->create([
            'category_id' => 2,
            'barcode' => 626824190040,
            'name' => 'Neon Haze',
            'brewery' => 'Amsterdam Brewing',
            'alcohol_percent' => 5.7,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => null,
            'name' => 'Light Work',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 4.1,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 2,
            'barcode' => 628669010101,
            'name' => 'Mad Tom',
            'brewery' => 'Muskoka Brewery',
            'alcohol_percent' => 6.4,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 5,
            'barcode' => null,
            'name' => 'Donna',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 5.2,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 5,
            'barcode' => 627843601548,
            'name' => 'Pilly',
            'brewery' => 'Mascot Brewery',
            'alcohol_percent' => 5.7,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => 628055459545,
            'name' => 'Sun Daze Rose',
            'brewery' => 'Bench Brewing Company',
            'alcohol_percent' => 4,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 5,
            'barcode' => 627843580249,
            'name' => 'Lagered Blonde',
            'brewery' => 'Henderson Brewing Co',
            'alcohol_percent' => 4.8,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => 627843580232,
            'name' => 'Henderson\'s Best Amber Ale',
            'brewery' => 'Henderson Brewing Co',
            'alcohol_percent' => 5.5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => 812652000020,
            'name' => 'Blueberry Blonde',
            'brewery' => 'Broadhead Brewery',
            'alcohol_percent' => 5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Nuova',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 5.8,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 5,
            'barcode' => null,
            'name' => 'Cold Comfort',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 6.7,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Double Small Hours',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 9.2,
            'has_lactose' => true,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Glory Days',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 4.5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Gelato Sour Strawberry & Vanilla',
            'brewery' => 'Fine Balance Brewing Company',
            'alcohol_percent' => 5.4,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => 628451660637,
            'name' => 'Pineapple Sour',
            'brewery' => 'Brock St. Brewing Company',
            'alcohol_percent' => 5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => 628634631034,
            'name' => 'Fiddle & Field',
            'brewery' => 'Quayle Brewery Inc',
            'alcohol_percent' => 5.6,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 2,
            'barcode' => 7350064990759,
            'name' => 'Zodiak',
            'brewery' => 'Omnipollo',
            'alcohol_percent' => 6.2,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => 186360051583,
            'name' => 'Jam Up Berries',
            'brewery' => 'Collective Arts Brewing Limited',
            'alcohol_percent' => 5.2,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => 186360050197,
            'name' => 'Jam Up The Mash',
            'brewery' => 'Collective Arts Brewing Limited',
            'alcohol_percent' => 5.2,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 5,
            'barcode' => 627167100406,
            'name' => 'Premium Lager',
            'brewery' => 'Wayne Gretzky Craft Brewing',
            'alcohol_percent' => 5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => 628055459460,
            'name' => 'Berry Fields Tart & Juicy Fruit Sour',
            'brewery' => 'Bench Brewing Company',
            'alcohol_percent' => 5.4,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => 628669093289,
            'name' => 'Ebb & Flow',
            'brewery' => 'Muskoka Brewery',
            'alcohol_percent' => 5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => 834873000320,
            'name' => 'Aloha Sour',
            'brewery' => 'Side Launch Brewing Company',
            'alcohol_percent' => 4.3,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 4,
            'barcode' => 675325010005,
            'name' => 'Apple Cider',
            'brewery' => 'Somersby',
            'alcohol_percent' => 4.5,
            'has_lactose' => false,
            'photo' => null
        ]);


//        START CHECKING CATEGORIES HERE


        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => null,
            'name' => 'Fat Tire',
            'brewery' => 'New Belgium Brewing',
            'alcohol_percent' => 5.2,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => null,
            'name' => 'Absent Landlord',
            'brewery' => 'Cowbell Brewing Co.',
            'alcohol_percent' => 5.3,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => null,
            'name' => 'Italia Pale Ale',
            'brewery' => 'Birra Fanelli',
            'alcohol_percent' => 4.5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => null,
            'name' => 'Hello, Friends!',
            'brewery' => 'Left Field Brewery',
            'alcohol_percent' => 6,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => null,
            'name' => 'Another Hazy Beer',
            'brewery' => 'Kensington Brewing Co.',
            'alcohol_percent' => 5.5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => null,
            'name' => 'Hop!',
            'brewery' => 'Vagabond',
            'alcohol_percent' => 2.5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => null,
            'name' => 'Skvader',
            'brewery' => 'Jackallhop',
            'alcohol_percent' => 8.6,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => null,
            'name' => 'Houblon Chouffe',
            'brewery' => 'Brasserie D’Achouffe SA',
            'alcohol_percent' => 9,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => null,
            'name' => 'Clutch',
            'brewery' => 'Redline Brewhoust',
            'alcohol_percent' => 4.8,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 5,
            'barcode' => null,
            'name' => 'Classic Organic Pilsner',
            'brewery' => 'Mill St. Brewery',
            'alcohol_percent' => 6,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Jutsu',
            'brewery' => 'Bellwoods Brewery',
            'alcohol_percent' => 5.6,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Head Stock',
            'brewery' => 'Nickelbrook Brewing Co.',
            'alcohol_percent' => 7,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Wicked Awesome',
            'brewery' => 'Nickelbrook Brewing Co.',
            'alcohol_percent' => 6.5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Ghost Orchid',
            'brewery' => 'Bellwoods Brewery',
            'alcohol_percent' => 6.3,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Naughty Neighbor',
            'brewery' => 'Nickelbrook Brewing Co.',
            'alcohol_percent' => 4.9,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Octopus Wants to Fight',
            'brewery' => 'Great Lakes Brewery',
            'alcohol_percent' => 6.2,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 3,
            'barcode' => null,
            'name' => 'Killarney Cream Ale',
            'brewery' => 'Manitoulin Brewing Co.',
            'alcohol_percent' => 5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 2,
            'barcode' => null,
            'name' => 'Grande Ave',
            'brewery' => 'Grand River Brewing',
            'alcohol_percent' => 6.5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Bubble Stash',
            'brewery' => 'Hop Valley Brewing',
            'alcohol_percent' => 6.2,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 5,
            'barcode' => null,
            'name' => 'Hauler Lager',
            'brewery' => 'Farm League Brewing',
            'alcohol_percent' => 4.8,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Upside',
            'brewery' => 'Wellington Brewery',
            'alcohol_percent' => 6.8,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Queen of Wheat',
            'brewery' => 'Spearhead Brewing Company',
            'alcohol_percent' => 5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Hawaiian Style',
            'brewery' => 'Spearhead Brewing Company',
            'alcohol_percent' => 6,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Detour',
            'brewery' => 'Muskoka Brewery',
            'alcohol_percent' => 4.3,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Northbound Lager',
            'brewery' => 'Side Launch Brewing Company',
            'alcohol_percent' => 6,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Dream Pop',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 6.1,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Costal Wave',
            'brewery' => 'Lost Craft Inc.',
            'alcohol_percent' => 6,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'High Tide',
            'brewery' => 'Whitewater Brewing Co.',
            'alcohol_percent' => 6.9,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Chicken Man Pale Ale',
            'brewery' => 'Furnace Room Brewery',
            'alcohol_percent' => 5.4,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'El Rosado',
            'brewery' => 'Fairweather Brewing Co.',
            'alcohol_percent' => 4.2,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Bellweiser',
            'brewery' => 'Bellwoods Brewery',
            'alcohol_percent' => 4.8,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 2,
            'barcode' => null,
            'name' => 'Fresh Ideas',
            'brewery' => 'Bell City Brewery',
            'alcohol_percent' => 6.3,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Light Eh! Lager',
            'brewery' => 'Kingsville Brewery',
            'alcohol_percent' => 4,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Lemon & Lime Beach Lager',
            'brewery' => 'Whitewater Brewing Co.',
            'alcohol_percent' => 4,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Mango & Passion Fruit Milkshake IPA',
            'brewery' => 'Collective Arts Brewing Limited',
            'alcohol_percent' => 5.9,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Samurai Kettle Sour',
            'brewery' => 'CAMERON\'S Brewing Company',
            'alcohol_percent' => 5.4,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Des Cotes',
            'brewery' => 'Bearle',
            'alcohol_percent' => 5,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Worlds Away',
            'brewery' => 'Flying Monkey',
            'alcohol_percent' => 4.7,
            'has_lactose' => false,
            'photo' => null
        ]);
        Beer::factory()->create([
            'category_id' => 1,
            'barcode' => null,
            'name' => 'Amsterdam Blonde',
            'brewery' => 'Amsterdam Brewing',
            'alcohol_percent' => 5,
            'has_lactose' => false,
            'photo' => null
        ]);
    }
}
