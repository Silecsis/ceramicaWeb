<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PieceController;
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

//--------MODELO USUARIOS----------------

Route::get('/users', [UserController::class,'listar']
)->middleware(['auth'])->name('users');

Route::get('/edit.admin', [UserController::class,'showAdmin']
)->middleware(['auth'])->name('edit.admin');

Route::get('/edit.profile', [UserController::class,'show']
)->middleware(['auth'])->name('edit.profile');

Route::get('/new.user', function () {
    return view('/users/new-user');
})->middleware(['auth'])->name('new.user');

Route::get('user/avatar/{filename}', [UserController::class,'getImage']
)->middleware(['auth'])->name('user.avatar');

Route::get('/destroy.admin', [UserController::class,'destroyAdmin']
)->middleware(['auth'])->name('destroy.admin');

Route::post('/update.admin', [UserController::class,'updateAdmin']
)->middleware(['auth'])->name('update.admin');

Route::post('/update.profile', [UserController::class,'update']
)->middleware(['auth'])->name('update.profile');

Route::post('/create.admin', [UserController::class,'createAdmin']
)->middleware(['auth'])->name('create.admin');

//--------MODELO MATERIALES----------------
Route::get('/materials', [MaterialController::class,'listar']
)->middleware(['auth'])->name('materials');

Route::get('/new.material', function () {
    return view('/materials/new-material');
})->middleware(['auth'])->name('new.material');

Route::post('/create.material', [MaterialController::class,'create']
)->middleware(['auth'])->name('create.material');

Route::get('/edit.material', [MaterialController::class,'show']
)->middleware(['auth'])->name('edit.material');

Route::post('/update.material', [MaterialController::class,'update']
)->middleware(['auth'])->name('update.material');

Route::get('/destroy.material', [MaterialController::class,'destroy']
)->middleware(['auth'])->name('destroy.material');


//-----------MODELO VENTAS----------------
Route::get('/sales', [SaleController::class,'listar']
)->middleware(['auth'])->name('sales');

Route::get('/my.sales', [SaleController::class,'listarMisVentas']
)->middleware(['auth'])->name('my.sales');

Route::get('/new.sale', [SaleController::class,'create']
)->middleware(['auth'])->name('new.sale');


//-----------MODELO PIEZAS----------------
Route::get('/pieces', [PieceController::class,'listar']
)->middleware(['auth'])->name('pieces');

Route::get('/my.pieces', [PieceController::class,'listarMisPiezas']
)->middleware(['auth'])->name('my.pieces');

Route::get('/my.pieces.sold', [PieceController::class,'sold']
)->name('my.pieces.sold');

Route::get('/piece.detail', [PieceController::class,'detail']
)->middleware(['auth'])->name('piece.detail');


Route::get('/images/file/{filename}', [PieceController::class,'getImage']
)->name('image.file');

//--------------GENERAL------------------
Route::get('/error', function () {
    return view('/extras/error');
})->middleware(['auth'])->name('error');


require __DIR__.'/auth.php';
