<?php

use App\Http\Controllers\Private\API\BeerUpsertController;
use App\Http\Controllers\Private\API\DeleteRatingController;
use App\Http\Controllers\Private\API\PasswordUpdateController;
use App\Http\Controllers\Private\API\ProfileUpdateController;
use App\Http\Controllers\Private\API\UpdateUserRatingController;
use App\Http\Controllers\Private\API\UserBeersController;
use App\Http\Controllers\Private\Auth\LoginController;
use App\Http\Controllers\Private\Auth\LogoutController;
use App\Http\Controllers\Private\Auth\PasswordResetController;
use App\Http\Controllers\Private\Auth\RegisterController;
use App\Http\Controllers\Private\Delete\UserController;
use App\Http\Controllers\Public\Email\FeedbackController;
use App\Http\Controllers\Public\Email\ReportBeerController;
use App\Http\Controllers\Public\Get\AllBeersController;
use App\Http\Controllers\Public\Get\AllBreweriesController;
use App\Http\Controllers\Public\Get\AllCategoriesController;
use App\Http\Controllers\Public\Get\BeerByIdController;
use App\Http\Controllers\Public\Get\BeersByBarcodeController;
use App\Http\Controllers\Public\Get\BeersByBreweryController;
use App\Http\Controllers\Public\Get\BeersByCategoryController;
use App\Http\Controllers\Public\Get\BeersBySearchController;
use App\Http\Controllers\Public\Get\BeersByUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get('/{beer}', BeerByIdController::class);
    Route::get('/barcode/{beer}', BeersByBarcodeController::class);
    Route::get('/brewery/{beer}', BeersByBreweryController::class);
    Route::get('/category/{beer}', BeersByCategoryController::class);
    Route::get('/all/user/{beer}', BeersByUserController::class);
    Route::get('/search/{beer}', BeersBySearchController::class);
});
Route::get('/categories', AllCategoriesController::class);
Route::post('/report/beer', ReportBeerController::class);
Route::post('/report', FeedbackController::class);

// PRIVATE ROUTES
Route::middleware('auth:sanctum')->get('/profile', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/user/all', UserBeersController::class);
Route::middleware('auth:sanctum')->post('/profile/update', ProfileUpdateController::class);
Route::middleware('auth:sanctum')->post('/profile/password', PasswordUpdateController::class);
Route::middleware('auth:sanctum')->post('/beers/{beer}/update', BeerUpsertController::class);
Route::middleware('auth:sanctum')->delete('/ratings/{rating}', DeleteRatingController::class);
Route::middleware('auth:sanctum')->post('/user/beer/rating', UpdateUserRatingController::class);
Route::middleware('auth:sanctum')->delete('/users/delete', UserController::class);

//AUTH ROUTES
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::middleware(['auth:sanctum'])->post('/logout', LogoutController::class);
Route::post('/forgot-password', PasswordResetController::class);

