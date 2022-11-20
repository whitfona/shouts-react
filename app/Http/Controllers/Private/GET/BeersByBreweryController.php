<?php

namespace App\Http\Controllers\Private\GET;

use App\Http\Resources\BeerResource;
use App\Models\Beer;
use Illuminate\Routing\Controller;

class BeersByBreweryController extends Controller
{
    /**
     * GET all beers associated to a brewery
     *
     */
    public function __invoke($brewery)
    {
        $found = Beer::where('brewery', 'LIKE', '%' . $brewery . '%')->get();
        $foundCollection = BeerResource::collection($found);

        return response()->json($foundCollection);
    }
}
