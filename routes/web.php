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
    $found = Beer::all()->where('barcode', '=', $barcode)->first();

    return response()->json(new BeerResource($found));
})->name('beers.barcode.show');

/**
 * GET all beers associated to a brewery
 *
 */
Route::get('/beers/brewery/{beer}', function ($brewery) {
    $found = Beer::all()->where('brewery', 'LIKE', '%' . $brewery . '%');

    $foundCollection = BeerResource::collection($found);

    return response()->json($foundCollection);
})->name('beers.brewery.show');

/**
 * GET all beers associated to a category
 *
 */
Route::get('/beers/category/{beer}', function($category) {
    $found = Beer::all()->where('category_id', '=', $category);
    $foundCollection = BeerResource::collection($found);

    return response()->json($foundCollection);

})->name('beers.category.show');

/**
 * GET all beers associated to a user
 *
 */
Route::get('/beers/user/{beer}', function ($user) {
    $found = Rating::all()->where('user_id', '=', $user);
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
    $user = auth()->user();
    // Look for user with their rating
    $found = DB::table('beers')
        ->join('ratings', 'beers.id', '=', 'ratings.beer_id')
        ->join('categories', 'beers.category_id', '=', 'categories.id')
        ->where('ratings.user_id', '=', $user->id)
        ->where('barcode', '=', $barcode)
        ->get();

    // If no user with rating is found, search for just the beer
    if (count($found) < 1) {
        $found = DB::table('beers')
            ->join('ratings', 'beers.id', '=', 'ratings.beer_id')
            ->join('categories', 'beers.category_id', '=', 'categories.id')
            ->where('barcode', '=', $barcode)
            ->get(['ratings.beer_id', 'category_id', 'barcode', 'name', 'brewery', 'alcohol_percent', 'has_lactose', 'photo']);
    }

    return response()->json($found->first());
})->middleware('auth')->name('beers.user.barcode');

/**
 * GET beer with user ratings (if it exists) by beer_id
 *
 */
Route::get('/beers/user/{beer}', function ($beer) {
    $user = auth()->user();
    // Look for user with their rating
    $found = DB::table('beers')
        ->join('ratings', 'beers.id', '=', 'ratings.beer_id')
        ->join('categories', 'beers.category_id', '=', 'categories.id')
        ->where('ratings.user_id', '=', $user->id)
        ->where('ratings.beer_id', '=', $beer)
        ->get();

    // If no user with rating is found, search for just the beer
    if (count($found) < 1) {
        $found = DB::table('beers')
            ->join('ratings', 'beers.id', '=', 'ratings.beer_id')
            ->join('categories', 'beers.category_id', '=', 'categories.id')
            ->where('beer_id', '=', $beer)
            ->get(['ratings.beer_id', 'category_id', 'barcode', 'name', 'brewery', 'alcohol_percent', 'has_lactose', 'photo']);
    }

    return response()->json($found->first());
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
        'beer_id' =>  Rule::unique('ratings', 'beer_id')->where(function ($query) use ($user) {
            return $query->where('user_id', '=', $user->id);
        }),
        'brewery' => ['required', 'string', 'max:100'],
        'barcode' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
        'alcohol_percent' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
//        'photo' => ['sometimes', 'mimes:heic,jpg,jpeg,png,bmp,gif,svg,webp', 'max:5000', 'nullable'],
        'comment' => ['sometimes', 'string', 'max:280', 'nullable'],
        'rating' => ['required', 'numeric', 'gte:0', 'lte:10', 'nullable'],
        'category_id' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
    ],
    [
        'beer_id.unique' => 'You have already rated this beer.'
    ]
    );

    $beer = [
       'barcode' => $request->barcode,
       'name' => $request->name,
       'brewery' => $request->brewery,
       'alcohol_percent' => $request->alcohol_percent,
       'has_lactose' => request()->has('hasLactose'),
       'photo' => $request->photo,
       'category_id' => $request->category_id,
    ];

    // 2. If beer_id is sent with the response
    //  2.1 Update beer and use the beer_id
    if (Beer::find($request->beer_id)) {
        $foundBeer = Beer::find($request->beer_id);
        $foundBeer->barcode = $request->barcode;
        $foundBeer->name = $request->name;
        $foundBeer->brewery = $request->brewery;
        $foundBeer->alcohol_percent = $request->alcohol_percent;
        $foundBeer->has_lactose = request()->has('hasLactose');
        $foundBeer->photo = $request->photo;
        $foundBeer->category_id = $request->category_id;

        $foundBeer->save();
        $beer = $foundBeer;
    } else {
        // 3. If beer_id is NOT set with the response
        //  3.1 Create the beer and use the beer_id
        $newBeer = new Beer;
        $newBeer->barcode = $request->barcode;
        $newBeer->name = $request->name;
        $newBeer->brewery = $request->brewery;
        $newBeer->alcohol_percent = $request->alcohol_percent;
        $newBeer->has_lactose = request()->has('hasLactose');
        $newBeer->photo = $request->photo;
        $newBeer->category_id = $request->category_id;

        $newBeer->save();
        $beer = $newBeer;
    }

    // 4. Add beer_id, user_id, rating and comment to Ratings table
    $newRating = new Rating;

//    $newRating->beer_id = $beer;
//    $newRating->user_id = $user;
    $newRating->beer()->associate($beer);
    $newRating->user()->associate($user);
    $newRating->rating = $request->rating;
    $newRating->comment = $request->comment;

    $newRating->save();

    // return JSON 202 message
    return response()->json('Beer successfully added', 201);

})->middleware('auth')->name('beers.store');

/**
 * DELETE a beer for the authenticated user
 */
Route::delete('/beers/{rating}', function ($rating) {
    $user = auth()->user();
    $rating = Rating::find($rating);
    $rating->delete();

    return response()->json('Beer successfully deleted', 202);
})->middleware('auth')->name('beers.user.destroy');



Route::get('/beers/add-bevvie', function () {
    return Inertia::render('AddBevvie');
})->name('beer.create');


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

require __DIR__.'/auth.php';
