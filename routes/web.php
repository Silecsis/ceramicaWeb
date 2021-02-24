<?php

use App\Http\Controllers\UserController;
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
    return view('auth.login');
})->middleware('guest');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/users', [UserController::class,'index']
)->middleware(['auth'])->name('users');

Route::get('/destroy/{id}', [UserController::class,'destroy']
)->middleware(['auth'])->name('destroy');


Route::get('/error', function () {
    return view('error');
})->middleware(['auth'])->name('error');


require __DIR__.'/auth.php';
