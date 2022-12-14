<?php

namespace App\Http\Controllers\Private\API;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserBeersController extends Controller
{
    /**
     * Get all beers associated to a user
     *
     */
    public function __invoke(Request $request)
    {
        $found = Rating::where('user_id', '=', $request->user()->id)->get();
        $results = $found->map(function ($beer) {
            return  [
                'id' => $beer->beer->id,
                "barcode" => $beer->beer->barcode,
                "name" => $beer->beer->name,
                "brewery" => $beer->beer->brewery,
                "alcohol_percent" => $beer->beer->alcohol_percent,
                "photo" => $beer->beer->photo,
                "category" => $beer->beer->category->type,
                "avg_rating" => null,
                "has_lactose" => $beer->beer->has_lactose,
                "ratings" => [
                    [
                        "id" => $beer->id,
                        "user_id" => $beer->user->id,
                        "user" => $beer->user->name,
                        "rating" => $beer->rating,
                        "comment" => $beer->comment,
                        "user_photo" => $beer->user->profile_image,
                        "date_added" => $beer->created_at->toDateString()
                    ]
                ]
            ];
        });

        $final = collect($results)->values()->all();

        return response()->json($final);
    }
}
