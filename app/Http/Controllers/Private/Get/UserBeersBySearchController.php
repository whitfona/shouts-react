<?php

namespace App\Http\Controllers\Private\Get;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class UserBeersBySearchController extends Controller
{
    /**
    * Get all beers for the authenticated user by search term
    *
    */
    public function __invoke($search)
    {
        $user = auth()->user();
        $found = DB::table('beers')
            ->join('ratings', 'beers.id', '=', 'ratings.beer_id')
            ->join('categories', 'beers.category_id', '=', 'categories.id')
            ->where('ratings.user_id', '=', $user->id)
            ->where(function ($query) use ($search) {
                $query
                    ->where('beers.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('beers.brewery', 'LIKE', '%' . $search . '%');
            })
            ->get();

        return response()->json($found);
    }
}
