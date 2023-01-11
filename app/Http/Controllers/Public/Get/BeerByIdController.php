<?php

namespace App\Http\Controllers\Public\Get;

use App\Http\Resources\BeerResource;
use App\Models\Beer;
use Illuminate\Routing\Controller;

class BeerByIdController extends Controller
{
    /**
     * Get single beer by its ID
     *
     */
    public function __invoke(Beer $beer)
    {
        $found = Beer::where('id', '=', $beer->id)->first();

        // If beer doesn't exist return early
        if (!$found) {
            return response()->json(null);
        }

        return response()->json(new BeerResource($found));
    }
}
