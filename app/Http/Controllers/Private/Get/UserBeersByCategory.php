<?php

namespace App\Http\Controllers\Private\Get;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UserBeersByCategory extends Controller
{
    /**
     * Get all beers for the authenticated user by category
     *
     */
    public function __invoke($category)
    {
        $user = auth()->user();
        $found = DB::table('beers')
            ->join('ratings', 'beers.id', '=', 'ratings.beer_id')
            ->join('categories', 'beers.category_id', '=', 'categories.id')
            ->where('ratings.user_id', '=', $user->id)
            ->where('beers.category_id', '=', $category)
            ->get();

        return response()->json($found);
    }
}
