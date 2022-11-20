<?php

namespace App\Http\Controllers\Private\Get;

use App\Models\Beer;
use App\Models\Rating;
use Illuminate\Routing\Controller;

class UserBeersByBarcodeController extends Controller
{
    /**
     * Get beer with user ratings (if it exists) for scanned barcode
     *
    */
    public function __invoke($barcode)
    {
        // Check if the beer exists in the database
        $beer = Beer::where('barcode', '=', $barcode)->first();

        // If beer doesn't exist return early
        if (!$beer) {
            return response()->json(null);
        }

        // Check if the auth user has rated the beer
        $foundRating = Rating::where('user_id', auth()->user()->id)->where('beer_id', $beer->id)->first();

        // If no user with rating is found, search for just the beer
        if ($foundRating) {
            $result = [
                'id' => $beer->id,
                'beer_id' => $beer->id,
                "category_id" => $beer->category_id,
                "barcode" => $beer->barcode,
                "name" => $beer->name,
                "brewery" => $beer->brewery,
                "alcohol_percent" => $beer->alcohol_percent,
                "photo" => $beer->photo,
                "has_lactose" => $beer->has_lactose,
                "rating" => $foundRating->rating,
                "comment" => $foundRating->comment
            ];
        } else {
            $result = [
                'id' => $beer->id,
                'beer_id' => $beer->id,
                "category_id" => $beer->category_id,
                "barcode" => $beer->barcode,
                "name" => $beer->name,
                "brewery" => $beer->brewery,
                "alcohol_percent" => $beer->alcohol_percent,
                "photo" => $beer->photo,
                "has_lactose" => $beer->has_lactose,
                "rating" => null,
                "comment" => null
            ];
        }

        return response()->json($result);
    }
}
