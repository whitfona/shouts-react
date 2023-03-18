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

            // Convert the base64 string to a binary string
            $imageData = base64_decode($request->photo);
            $image = Image::make($imageData);

            // Use exif_read_data() to read the orientation metadata
            $exif = exif_read_data('data://image/jpeg;base64,' . base64_encode($imageData));
            if (!empty($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                if ($orientation === 2) { // EXIF orientation value for flipped horizontally
                    $image->flip('h');
                }
                elseif ($orientation === 3) { // EXIF orientation value for rotated 180 degrees
                    $image->rotate(180);
                }
                elseif ($orientation === 4) { // EXIF orientation value for flipped vertically
                    $image->flip('v');
                }
                elseif ($orientation === 5) { // EXIF orientation value for flipped horizontally and rotated 270 degrees
                    $image->flip('h')->rotate(-90);
                }
                elseif ($orientation === 6) { // EXIF orientation value for rotated 90 degrees
                    $image->rotate(-90);
                }
                elseif ($orientation === 7) { // EXIF orientation value for flipped horizontally and rotated 90 degrees
                    $image->flip('h')->rotate(90);
                }
                elseif ($orientation === 8) { // EXIF orientation value for rotated 270 degrees
                    $image->rotate(-90);
                }
            }

            $image->resize(512, null, function ($constraint) {
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

        return response('Beer not updated.', 200);
    }
}
