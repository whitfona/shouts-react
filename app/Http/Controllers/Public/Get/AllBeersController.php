<?php

namespace App\Http\Controllers\Public\Get;

use App\Http\Resources\BeerResource;
use App\Models\Beer;
use Illuminate\Routing\Controller;

class AllBeersController extends Controller
{
    /**
     * GET all beers with all users ratings & comments for each beer
     *
     */
    public function __invoke()
    {
        $allBeers = BeerResource::collection(Beer::all());

        return response()->json($allBeers);
    }
}
