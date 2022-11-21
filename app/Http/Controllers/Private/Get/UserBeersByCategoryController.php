<?php

namespace App\Http\Controllers\Private\Get;

use App\Models\Beer;
use Illuminate\Routing\Controller;

class UserBeersByCategoryController extends Controller
{
    /**
     * Get all beers for the authenticated user by category
     *
     */
    public function __invoke($category)
    {
        $found = Beer::with('category')
            ->join('ratings', 'ratings.beer_id', '=', 'beers.id')
            ->where('ratings.user_id', auth()->user()->id)
            ->where('beers.category_id', '=', $category)
            ->get();

        return response()->json($found);
    }
}
