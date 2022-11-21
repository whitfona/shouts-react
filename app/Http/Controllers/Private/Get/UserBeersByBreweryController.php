<?php

namespace App\Http\Controllers\Private\Get;

use App\Models\Beer;
use Illuminate\Routing\Controller;

class UserBeersByBreweryController extends Controller
{
    /**
     * Get all beers for the authenticated user by brewery
     *
     */
    public function __invoke($brewery)
    {
        $found = Beer::with('category')
            ->join('ratings', 'ratings.beer_id', '=', 'beers.id')
            ->where('ratings.user_id', auth()->user()->id)
            ->where('beers.brewery', 'LIKE', '%' . $brewery . '%')
            ->get();


        return response()->json($found);
    }
}
