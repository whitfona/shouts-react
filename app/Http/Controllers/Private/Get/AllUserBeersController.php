<?php

namespace App\Http\Controllers\Private\Get;

use App\Models\Beer;
use Illuminate\Routing\Controller;

class AllUserBeersController extends Controller
{
    /**
     * Get all beers for the authenticated user
     *
     */
    public function __invoke()
    {
        $found = Beer::with('category')
            ->join('ratings', 'ratings.beer_id', '=', 'beers.id')
            ->where('ratings.user_id', auth()->user()->id)
            ->get();

        return response()->json($found);
    }
}
