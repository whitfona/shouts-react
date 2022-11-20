<?php

namespace App\Http\Controllers\Private\Get;

use App\Models\Beer;
use App\Models\Rating;
use Illuminate\Routing\Controller;

class UserBeersByBeerIdController extends Controller
{
    /**
     * Get beer with user ratings by beer_id
     *
     */
    public function __invoke($beerId)
    {
        // Find beer, assume beer always exists since user is using the typeahead
        $beer = Beer::find($beerId);

        // Check if the auth user has rated the beer
        $foundRating = Rating::where('user_id', auth()->user()->id)->where('beer_id', $beerId)->first();

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
