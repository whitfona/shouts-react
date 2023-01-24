<?php

namespace App\Http\Controllers\Private\API;

use App\Models\Beer;
use App\Models\Rating;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Intervention\Image\Facades\Image;

class BeerUpsertController extends Controller
{
    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();

        // 1. Validate data is correctly submitted
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'beer_id' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
            'brewery' => ['required', 'string', 'max:100'],
            'barcode' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
            'alcohol_percent' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
            'photo' => ['sometimes', 'string'],
            'comment' => ['sometimes', 'string', 'max:280', 'nullable'],
            'rating' => ['required', 'numeric', 'gte:0', 'lte:5', 'nullable'],
            'category_id' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
        ]);

        $photoName = $request->photo;
        if ($request->photo) {
            $photoName = time() . '.' . 'jpg';
            Image::make($request->photo)
                ->resize(512, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->orientate()
                ->save(public_path('/storage/beers/') . $photoName);
        }

        //  Create new beer
        $beer = new Beer;
        //  Update beer
        if (Beer::find($request->beer_id)) {
            $beer = Beer::find($request->beer_id);
        }
        $beer->barcode = $request->barcode;
        $beer->name = $request->name;
        $beer->brewery = $request->brewery;
        $beer->alcohol_percent = $request->alcohol_percent;
        $beer->has_lactose = request()->has('hasLactose');
        if ($photoName) {
            $beer->photo = $photoName;
        }
        if (!$beer->photo && !$photoName) {
            $beer->photo = 'zzzzempty-sour-glass.png';
        }
        $beer->category_id = $request->category_id;
        $beer->save();

        // Update Rating
        $previousRating = Rating::where('beer_id', $beer->id)->where('user_id', $user->id)->first();
        if ($previousRating) {
            $previousRating->rating = $request->rating;
            $previousRating->comment = $request->comment;

            $previousRating->save();
        } else {
            // Create new Rating
            $newRating = new Rating;

            $newRating->beer()->associate($beer);
            $newRating->user()->associate($user);
            $newRating->rating = $request->rating;
            $newRating->comment = $request->comment;

            $newRating->save();
        }

        return response('Beer successfully updated.', 200);
    }
}
