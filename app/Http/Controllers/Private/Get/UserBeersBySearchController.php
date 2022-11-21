<?php

namespace App\Http\Controllers\Private\Get;

use App\Models\Beer;
use Illuminate\Routing\Controller;

class UserBeersBySearchController extends Controller
{
    /**
    * Get all beers for the authenticated user by search term
    *
    */
    public function __invoke($search)
    {
        $found = Beer::with('category')
            ->join('ratings', 'ratings.beer_id', '=', 'beers.id')
            ->where('ratings.user_id', auth()->user()->id)
            ->where(function ($query) use ($search) {
                $query
                    ->where('beers.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('beers.brewery', 'LIKE', '%' . $search . '%');
            })
            ->get();

        return response()->json($found);
    }
}
