<?php

use App\Http\Resources\BeerResource;
use App\Models\Beer;
use App\Models\Category;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * START OF PUBLIC ROUTES
 *
 *
 *
 */
/**
 * GET all beers with all users ratings & comments for each beer
 *
 */
Route::get('/beers', function () {
    $allBeers = BeerResource::collection(Beer::all());

    return response()->json($allBeers);
})->name('beers.index');

/**
 * GET all users ratings & comments for a SINGLE beer using the beer's barcode
 *
 */
Route::get('/beers/barcode/{beer}', function ($barcode) {
    $found = Beer::where('barcode', '=', $barcode)->first();

    // If beer doesn't exist return early
    if (!$found) {
        return response()->json(null);
    }

    return response()->json([new BeerResource($found)]);
})->name('beers.barcode.show');

/**
 * GET all beers associated to a brewery
 *
 */
Route::get('/beers/brewery/{beer}', function ($brewery) {
    $found = Beer::where('brewery', 'LIKE', '%' . $brewery . '%')->get();
    $foundCollection = BeerResource::collection($found);

    return response()->json($foundCollection);
})->name('beers.brewery.show');

/**
 * GET all beers associated to a category
 *
 */
Route::get('/beers/category/{beer}', function($category) {
    $found = Beer::where('category_id', '=', $category)->get();
    $foundCollection = BeerResource::collection($found);

    return response()->json($foundCollection);

})->name('beers.category.show');

/**
 * GET all beers associated to a user
 *
 */
Route::get('/beers/user/all/{beer}', function ($user) {
    $found = Rating::where('user_id', '=', $user)->get();
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
})->name('beers.user.show');

/**
 * GET all beers with name or brewery that matches the search criteria
 *
 */
Route::get('/beers/search/{beer}', function ($search) {
    $found = Beer::where('name', 'LIKE', '%' . $search . '%')->orWhere('brewery', 'LIKE', '%' . $search . '%')->get();
    $results = BeerResource::collection($found);

    return response()->json($results);
})->name('beers.search.show');

/**
 * GET all categories
 *
 */
Route::get('/categories', function () {
    $categories = Category::all();

    return response()->json($categories);
})->name('categories.index');


/*
 * START OF PRIVATE ROUTES
 *
 *
 *
 */
/**
 * GET all beers for the authenticated user
 */
Route::get('/beers/user', function () {
    $user = auth()->user();
    $found = DB::table('beers')
        ->join('ratings', 'beers.id', '=', 'ratings.beer_id')
        ->join('categories', 'beers.category_id', '=', 'categories.id')
        ->where('ratings.user_id', '=', $user->id)
        ->get();

    return response()->json($found);
})->middleware('auth')->name('beers.user.index');

/**
 * GET all beers for the authenticated user by brewery
 *
 */
Route::get('/beers/user/brewery/{beer}', function ($brewery) {
    $user = auth()->user();
    $found = DB::table('beers')
        ->join('ratings', 'beers.id', '=', 'ratings.beer_id')
        ->join('categories', 'beers.category_id', '=', 'categories.id')
        ->where('ratings.user_id', '=', $user->id)
        ->where('beers.brewery', 'LIKE', '%' . $brewery . '%')
        ->get();

    return response()->json($found);
})->middleware('auth')->name('beers.user.brewery');

/**
 * GET all beers for the authenticated user by category
 *
 */
Route::get('/beers/user/category/{beer}', function ($category) {
    $user = auth()->user();
    $found = DB::table('beers')
        ->join('ratings', 'beers.id', '=', 'ratings.beer_id')
        ->join('categories', 'beers.category_id', '=', 'categories.id')
        ->where('ratings.user_id', '=', $user->id)
        ->where('beers.category_id', '=', $category)
        ->get();

    return response()->json($found);
})->middleware('auth')->name('beers.user.category');

/**
 * GET all beers for the authenticated user by search term
 *
 */
Route::get('/beers/user/search/{beer}', function ($search) {
    $user = auth()->user();
    $found = DB::table('beers')
        ->join('ratings', 'beers.id', '=', 'ratings.beer_id')
        ->join('categories', 'beers.category_id', '=', 'categories.id')
        ->where('ratings.user_id', '=', $user->id)
        ->where(function ($query) use ($search) {
            $query
                ->where('beers.brewery', 'LIKE', '%' . $search . '%')
                ->orWhere('beers.brewery', 'LIKE', '%' . $search . '%');
        })
        ->get();

    return response()->json($found);
})->middleware('auth')->name('beers.user.search');

/**
 * GET beer with user ratings (if it exists) for scanned barcode
 *
 */
Route::get('/beers/user/barcode/{beer}', function ($barcode) {
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
})->middleware('auth')->name('beers.user.barcode');

/**
 * GET beer with user ratings (if it exists) by beer_id
 *
 */
Route::get('/beers/user/{beer}', function ($beerId) {
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
})->middleware('auth')->name('beers.user.beer');

/**
 * POST add a beer for the authenticated user
 *
 */
Route::post('/beers/user', function (Request $request) {

    $user = auth()->user();
    // 1. Validate data is correctly submitted
    $request->validate([
        'name' => ['required', 'string', 'max:100'],
        'beer_id' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
        'brewery' => ['required', 'string', 'max:100'],
        'barcode' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
        'alcohol_percent' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
//        'photo' => ['sometimes', 'mimes:heic,jpg,jpeg,png,bmp,gif,svg,webp', 'max:5000', 'nullable'],
        'comment' => ['sometimes', 'string', 'max:280', 'nullable'],
        'rating' => ['required', 'numeric', 'gte:0', 'lte:10', 'nullable'],
        'category_id' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
    ]);

//    $validated['hasLactose'] = request()->has('hasLactose');
//    if (request()->has('image')) {
//        $validated['image'] = time() . '.' . 'jpg';
//        Image::make(request()->file('image'))
//            ->resize(512, null, function ($constraint) {
//                $constraint->aspectRatio();
//            })
//            ->save(public_path('/storage/sours/') . $validated['image']);
//    }

    //  Update beer
    if (Beer::find($request->beer_id)) {
        $beer = Beer::find($request->beer_id);
    } else {
        //  Create new beer
        $beer = new Beer;
    }
    $beer->barcode = $request->barcode;
    $beer->name = $request->name;
    $beer->brewery = $request->brewery;
    $beer->alcohol_percent = $request->alcohol_percent;
    $beer->has_lactose = request()->has('hasLactose');
    $beer->photo = $request->photo;
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

    return redirect(route('dashboard'))->with('message', 'Beer successfully saved.');
})->middleware('auth')->name('beers.store');

/**
 * GET user profile information
 *
 */
Route::get('/profile', function() {
    $user = User::find(auth()->user()->id);

    return response()->json($user);
})->middleware('auth')->name('user.show');

/**
 * POST update user profile information
 *
 */
Route::post('/profile', function (Request $request) {
    $request->validate([
        'user_id' => ['required', 'numeric', 'gte:0'],
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'id')->ignore($request->user_id)],
        //        'photo' => ['sometimes', 'mimes:heic,jpg,jpeg,png,bmp,gif,svg,webp', 'max:5000', 'nullable'],
    ]);

    $user = User::find($request->user_id);

    $user->name = $request->name;
    $user->email = $request->email;
//    $user->photo = $request->photo;

    $user->save();

    return redirect(route('profile'))->with('message', 'Profile successfully saved.');
})->middleware('auth')->name('user.store');

/**
 * DELETE a beer for the authenticated user
 */
Route::post('/beers/delete', function (Request $request) {
    $user = auth()->user();
    $rating = Rating::where('beer_id', $request->beer_id)->where('user_id', $user->id)->first();
    $rating->delete();

    return redirect(route('dashboard'))->with('message', 'Beer successfully deleted.');
})->middleware('auth')->name('beers.user.destroy');




Route::get('/beers/add-bevvie', function () {
    return Inertia::render('AddBevvie');
})->name('beer.create');

Route::get('/beers/update-bevvie', function () {
    return Inertia::render('UpdateBevvie');
})->name('beer.update');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/update-profile', function () {
    return Inertia::render('Profile');
})->middleware(['auth', 'verified'])->name('profile');

require __DIR__.'/auth.php';
