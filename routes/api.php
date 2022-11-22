<?php

use App\Http\Controllers\Public\Get\AllBeersController;
use App\Http\Controllers\Public\Get\AllCategoriesController;
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
Route::prefix('beers')->group(function () {
    Route::get('/', AllBeersController::class)->name('beers.index');
    Route::get('/barcode/{beer}', BeersByBarcodeController::class)->name('beers.barcode.show');
    Route::get('/brewery/{beer}', BeersByBreweryController::class)->name('beers.brewery.show');
    Route::get('/category/{beer}', BeersByCategoryController::class)->name('beers.category.show');
    Route::get('/all/user/{beer}', BeersByUserController::class)->name('beers.user.show');
    Route::get('/search/{beer}', BeersBySearchController::class)->name('beers.search.show');
});
Route::get('/categories', AllCategoriesController::class)->name('categories.index');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
