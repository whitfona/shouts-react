<?php

namespace App\Http\Controllers\Public\Get;

use App\Http\Resources\BeerResource;
use App\Models\Beer;
use Illuminate\Routing\Controller;

class BeersByCategoryController extends Controller
{
    /**
     * Get all beers associated to a category
     *
     */
    public function __invoke($category)
    {
        $found = Beer::where('category_id', '=', $category)->get();
        $foundCollection = BeerResource::collection($found);

        return response()->json($foundCollection);
    }
}
