<?php

namespace App\Http\Controllers\Public\Get;

use App\Http\Resources\BeerResource;
use App\Models\Beer;
use Illuminate\Routing\Controller;

class BeersBySearchController extends Controller
{
    /**
     * GET all beers with name or brewery that matches the search criteria
     *
     */
    public function __invoke($search)
    {
        $found = Beer::where('name', 'LIKE', '%' . $search . '%')->orWhere('brewery', 'LIKE', '%' . $search . '%')->get();
        $results = BeerResource::collection($found);

        return response()->json($results);
    }
}
