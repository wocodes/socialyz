<?php

use App\Http\Controllers\EventController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware('auth')->group(function() {
    Route::get('/dashboard', [EventController::class, "index"])->name('dashboard');

    Route::get('/host', function() {
        return view('host');
    })->name('event.create');

    Route::post('/host', [EventController::class, "store"])->name('event.store');

    Route::get('/join/{id}', [EventController::class, "join"])->name('event.join');

    Route::get('/verify/{username}', function($username) {
        $username = substr(base64_decode($username), 0, 4);
        $user = User::where('username', $username)->first();
        $user->verified_at = now();
        $user->save();

        return back();
    });
});

Route::get('/event/{event}', [EventController::class, "show"])->name('event.show');


require __DIR__.'/auth.php';
