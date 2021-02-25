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

Route::get('/users', [UserController::class,'listar']
)->middleware(['auth'])->name('users');

Route::get('/edit.admin', [UserController::class,'showAdmin']
)->middleware(['auth'])->name('edit.admin');

Route::get('user/avatar/{filename}', [UserController::class,'getImage']
)->middleware(['auth'])->name('user.avatar');

Route::get('/destroy.admin', [UserController::class,'destroyAdmin']
)->middleware(['auth'])->name('destroy.admin');

Route::post('/update.admin', [UserController::class,'updateAdmin']
)->middleware(['auth'])->name('update.admin');


Route::get('/error', function () {
    return view('/extras/error');
})->middleware(['auth'])->name('error');


require __DIR__.'/auth.php';
