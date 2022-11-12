<?php

use App\Http\Resources\BeerResource;
use App\Models\Beer;
use App\Models\Category;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
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

/**
 * GET all beers with all users ratings & comments for each beer
 *
 */
Route::get('/beers', function () {

    $allBeers = BeerResource::collection(Beer::all());

    return response()->json($allBeers);
})->name('beers.barcode.index');

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
    $found = Beer::all()->where('brewery', 'LIKE', $brewery);

    $foundCollection = BeerResource::collection($found);

    return response()->json($foundCollection);
})->name('beers.brewery.show');

/**
 * GET all beers associatd to a category
 *
 */
Route::get('/beers/category/{beer}', function($category) {
    $found = Beer::all()->where('category_id', '=', $category);
    $foundCollection = BeerResource::collection($found);

    return response()->json($foundCollection);

})->name('beers.category.show');

/**
 * Get all beers, comments and ratings for the signed in user
 */
Route::get('/beers/{user}', function() {
    $user = auth()->user();
    return Rating::all()->where('user_id', '=', $user->id);
})->middleware('auth')->name('beers.user.show');




Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
