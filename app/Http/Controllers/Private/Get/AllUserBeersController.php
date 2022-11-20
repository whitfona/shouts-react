<?php

namespace App\Http\Controllers\Private\Get;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AllUserBeersController extends Controller
{
    /**
     * Get all beers for the authenticated user
     *
     */
    public function __invoke()
    {
        $user = auth()->user();
        $found = DB::table('beers')
            ->join('ratings', 'beers.id', '=', 'ratings.beer_id')
            ->join('categories', 'beers.category_id', '=', 'categories.id')
            ->where('ratings.user_id', '=', $user->id)
            ->get();

        return response()->json($found);
    }
}
