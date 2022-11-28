<?php

use App\Http\Controllers\Private\Auth\LoginController;
use App\Http\Controllers\Public\Get\AllBeersController;
use App\Http\Controllers\Public\Get\AllBreweriesController;
use App\Http\Controllers\Public\Get\AllCategoriesController;
use App\Http\Controllers\Public\Get\BeersByBarcodeController;
use App\Http\Controllers\Public\Get\BeersByBreweryController;
use App\Http\Controllers\Public\Get\BeersByCategoryController;
use App\Http\Controllers\Public\Get\BeersBySearchController;
use App\Http\Controllers\Public\Get\BeersByUserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

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

Route::post('/register', LoginController::class);
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    $token = $user->createToken($request->email);

    return ['user' => $user, 'token' => $token->plainTextToken];
});
Route::middleware(['auth:sanctum'])->post('/logout', function (Request $request) {

    $request->user()->currentAccessToken()->delete();

    return response(['You successfully logged out'], 201);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
