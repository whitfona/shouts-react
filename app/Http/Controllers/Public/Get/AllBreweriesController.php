<?php

namespace App\Http\Controllers\Public\Get;

use App\Models\Beer;
use Illuminate\Routing\Controller;

class AllBreweriesController extends Controller
{
    /**
     * Get all beers with all users ratings & comments for each beer
     *
     */
    public function __invoke()
    {
        $breweries = Beer::all()->unique('brewery')->pluck('brewery');

        return response()->json($breweries);
    }
}
