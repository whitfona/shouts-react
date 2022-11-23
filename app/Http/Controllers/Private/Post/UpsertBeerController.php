<?php

namespace App\Http\Controllers\Private\Post;

use App\Models\Beer;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Intervention\Image\Facades\Image;

class UpsertBeerController extends Controller
{
    /**
     * POST add a beer for the authenticated user
     *
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();
        // 1. Validate data is correctly submitted
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'beer_id' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
            'brewery' => ['required', 'string', 'max:100'],
            'barcode' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
            'alcohol_percent' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
            'photo' => [ 'sometimes', 'max:5000', 'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !($value instanceof UploadedFile)) {
                        $fail('The '.$attribute.' must either be a string or file.');
                    }
                }
            ],
            'comment' => ['sometimes', 'string', 'max:280', 'nullable'],
            'rating' => ['required', 'numeric', 'gte:0', 'lte:10', 'nullable'],
            'category_id' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
        ]);

        $photoName = $request->photo;
        if ($request->photo && !$request->photo instanceof UploadedFile) {
            $split = preg_split("/(https:\/\/itsyourshout.ca\/storage\/beers\/)|(http:\/\/localhost:8000\/storage\/beers\/)/", $request->photo);
            $photoName = $split[1];
        }
        if ($request->photo && $request->photo instanceof UploadedFile) {
            $photoName = time() . '.' . 'jpg';
            Image::make($request->file('photo'))
                ->resize(512, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
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
        if (!$photoName) {
            $beer->photo = 'zzzzempty-sour-glass.png';
        } else {
            $beer->photo = $photoName;
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

        return redirect(route('dashboard'))->with('message', 'Bevvie successfully saved.');
    }
}
