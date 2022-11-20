<?php

namespace App\Http\Controllers\Public\Get;

use App\Http\Resources\BeerResource;
use App\Models\Beer;
use Illuminate\Routing\Controller;

class BeersByBarcodeController extends Controller
{
    /**
     * GET all users ratings & comments for a SINGLE beer using the beer's barcode
     *
     */
    public function __invoke($barcode)
    {
        $found = Beer::where('barcode', '=', $barcode)->first();

        // If beer doesn't exist return early
        if (!$found) {
            return response()->json(null);
        }

        return response()->json([new BeerResource($found)]);
    }
}
