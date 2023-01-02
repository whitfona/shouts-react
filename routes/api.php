<?php

use App\Http\Controllers\Private\API\BeerUpdateController;
use App\Http\Controllers\Private\API\DeleteRatingController;
use App\Http\Controllers\Private\API\ProfileUpdateController;
use App\Http\Controllers\Private\Auth\LoginController;
use App\Http\Controllers\Private\Auth\LogoutController;
use App\Http\Controllers\Private\Auth\RegisterController;
use App\Http\Controllers\Public\Get\AllBeersController;
use App\Http\Controllers\Public\Get\AllBreweriesController;
use App\Http\Controllers\Public\Get\AllCategoriesController;
use App\Http\Controllers\Public\Get\BeersByBarcodeController;
use App\Http\Controllers\Public\Get\BeersByBreweryController;
use App\Http\Controllers\Public\Get\BeersByCategoryController;
use App\Http\Controllers\Public\Get\BeersBySearchController;
use App\Http\Controllers\Public\Get\BeersByUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Intervention\Image\Facades\Image;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//PUBLIC ROUTES
Route::prefix('beers')->group(function () {
    Route::get('/', AllBeersController::class);
    Route::get('/breweries', AllBreweriesController::class);
    Route::get('/barcode/{beer}', BeersByBarcodeController::class);
    Route::get('/brewery/{beer}', BeersByBreweryController::class);
    Route::get('/category/{beer}', BeersByCategoryController::class);
    Route::get('/all/user/{beer}', BeersByUserController::class);
    Route::get('/search/{beer}', BeersBySearchController::class);
});
Route::get('/categories', AllCategoriesController::class);

// PRIVATE ROUTES
Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->post('/profile/update', ProfileUpdateController::class);
Route::middleware('auth:sanctum')->post('/beers/{beer}/update', BeerUpdateController::class);
Route::middleware('auth:sanctum')->delete('/ratings/{rating}', DeleteRatingController::class);

//AUTH ROUTES
Route::post('/register', RegisterController::class);
Route::post('login', LoginController::class);
Route::middleware(['auth:sanctum'])->post('/logout', LogoutController::class);

