<?php

use App\Models\Beer;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

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

Route::get('/beers', function() {
    return Beer::all();
})->name('beers.index');

Route::get('/beers/{user}', function(User $user) {
    return Beer::where('user_id', '=', $user->id)->get();
})->name('beers.user');

Route::post('/beers/', function () {
//    dd(request()->toArray());
    $validated = request()->validate([
        'name' => ['required', 'string', 'max:100'],
        'brewery' => ['required', 'string', 'max:100'],
        'alcohol_percent' => ['sometimes', 'numeric', 'gte:0', 'nullable'],
    ]);

    $validated['has_lactose'] = request()->has('has_lactose');
    auth()->user()->beers()->create($validated);

    return Response::HTTP_CREATED;

})->name('beers.store');

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
