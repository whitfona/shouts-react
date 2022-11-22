<?php

namespace App\Http\Controllers\Private\Post;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class RatingController extends Controller
{
    /**
     * POST update user profile information
     *
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'numeric', 'gte:0'],
            'beer_id' => ['required', 'sometimes', 'numeric', 'gte:0'],
            'rating' => ['required', 'numeric', 'gte:0', 'lte:10'],
            'comment' => ['sometimes', 'string', 'max:280', 'nullable'],
        ]);

        $rating = Rating::where('user_id', $request->user_id)->where('beer_id', $request->beer_id)->first();

        if (!$rating) {
            $rating = new Rating;

            $rating->user_id = $request->user_id;
            $rating->beer_id = $request->beer_id;
        }

        $rating->rating = $request->rating;
        $rating->comment = $request->comment;
        $rating->save();

        return redirect(route('welcome'))->with('message', 'Rating successfully saved.');
    }
}
