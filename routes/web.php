<?php

use App\Http\Controllers\Private\Get\AllUserBeersController;
use App\Http\Controllers\Private\Get\UserBeersByBarcodeController;
use App\Http\Controllers\Private\Get\UserBeersByBeerIdController;
use App\Http\Controllers\Private\Get\UserBeersByBreweryController;
use App\Http\Controllers\Private\Get\UserBeersByCategoryController;
use App\Http\Controllers\Private\Get\UserBeersBySearchController;
use App\Http\Controllers\Private\Get\UserProfileController;
use App\Http\Controllers\Private\Delete\BeerController;
use App\Http\Controllers\Private\Post\ProfileController;
use App\Http\Controllers\Private\Post\UpsertBeerController;
use App\Http\Controllers\Public\Get\AllBeersController;
use App\Http\Controllers\Public\Get\AllCategoriesController;
use App\Http\Controllers\Public\Get\BeersByBarcodeController;
use App\Http\Controllers\Public\Get\BeersByBreweryController;
use App\Http\Controllers\Public\Get\BeersByCategoryController;
use App\Http\Controllers\Public\Get\BeersBySearchController;
use App\Http\Controllers\Public\Get\BeersByUserController;
use App\Http\Resources\BeerResource;
use App\Models\Beer;
use App\Models\Category;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Intervention\Image\Facades\Image;
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
 */
Route::get('/beers', AllBeersController::class)->name('beers.index');

Route::get('/beers/barcode/{beer}', BeersByBarcodeController::class)->name('beers.barcode.show');

Route::get('/beers/brewery/{beer}', BeersByBreweryController::class)->name('beers.brewery.show');

Route::get('/beers/category/{beer}', BeersByCategoryController::class)->name('beers.category.show');

Route::get('/beers/user/all/{beer}', BeersByUserController::class)->name('beers.user.show');

Route::get('/beers/search/{beer}', BeersBySearchController::class)->name('beers.search.show');

Route::get('/categories', AllCategoriesController::class)->name('categories.index');

/*
 * START OF PRIVATE ROUTES
 *
 *
 */
Route::get('/beers/user', AllUserBeersController::class)->middleware('auth')->name('beers.user.index');
Route::get('/beers/user/brewery/{beer}', UserBeersByBreweryController::class)->middleware('auth')->name('beers.user.brewery');
Route::get('/beers/user/category/{beer}', UserBeersByCategoryController::class)->middleware('auth')->name('beers.user.category');
Route::get('/beers/user/search/{beer}', UserBeersBySearchController::class)->middleware('auth')->name('beers.user.search');
Route::get('/beers/user/barcode/{beer}', UserBeersByBarcodeController::class)->middleware('auth')->name('beers.user.barcode');
Route::get('/beers/user/{beer}', UserBeersByBeerIdController::class)->middleware('auth')->name('beers.user.beer');
Route::get('/profile', UserProfileController::class)->middleware('auth')->name('user.show');

Route::post('/beers/user', UpsertBeerController::class)->middleware('auth')->name('beers.store');
/**
 * HANDLE PHOTO UPLOAD
 *
 */
Route::post('/profile', ProfileController::class)->middleware('auth')->name('user.store');

Route::post('/beers/delete', BeerController::class)->middleware('auth')->name('beers.user.destroy');

/*
 * Routes
 *
 *
 */

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

Route::get('/beers/add-bevvie', function () {
    return Inertia::render('AddBevvie');
})->name('beer.create');

Route::get('/beers/update-bevvie', function () {
    return Inertia::render('UpdateBevvie');
})->name('beer.update');

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/update-profile', function () {
    return Inertia::render('Profile');
})->middleware(['auth', 'verified'])->name('profile');

require __DIR__.'/auth.php';
