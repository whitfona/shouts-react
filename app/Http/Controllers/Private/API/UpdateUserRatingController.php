<?php

namespace App\Http\Controllers\Private\API;

use App\Models\Rating;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class UpdateUserRatingController extends Controller
{
    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'beer_id' => ['required', 'sometimes', 'numeric', 'gte:0'],
            'rating' => ['required', 'numeric', 'gte:0', 'lte:10'],
            'comment' => ['sometimes', 'string', 'max:280', 'nullable'],
        ]);

        $rating = Rating::where('user_id', $request->user()->id)->where('beer_id', $request->beer_id)->first();

        if (!$rating) {
            $rating = new Rating;

            $rating->user_id = $request->user()->id;
            $rating->beer_id = $request->beer_id;
        }

        $rating->rating = $request->rating;
        $rating->comment = $request->comment;
        $rating->save();

        return response('Rating successfully updated.', 200);
    }
}
