<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ListingController::class, 'index'])->name('home');


Route::group([
    'as' => 'listings.',
    'prefix' => '/listings',
    'middleware' => 'auth',
], function () {
    Route::get('/create', [ListingController::class, 'create'])->name('create');
    Route::post('/create', [ListingController::class, 'store'])->name('store');
    Route::get('/manage', [ListingController::class, 'manage'])->name('manage');
    Route::get('/{listing}', [ListingController::class, 'show'])->withoutMiddleware('auth')->name('show');
    Route::get('/{listing}/edit', [ListingController::class, 'edit'])->name('edit');
    Route::patch('/{listing}', [ListingController::class, 'update'])->name('update');
    Route::delete('/{listing}', [ListingController::class, 'destroy'])->name('destroy');
});

Route::view('/register', 'users.register')->middleware('guest')->name('register');
Route::post('/register', [UserController::class, 'register'])->middleware('guest')->name('users.register');
Route::view('/login', 'users.login')->middleware('guest')->name('login');
Route::post('/login', [UserController::class, 'login'])->middleware('guest')->name('users.login');
Route::post('/logout', [UserController::class, 'logout'])->name('users.logout')->middleware('auth');
