<?php

use App\Http\Controllers\categoriaController;
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
    return view('template');
});

Route::view('/panel','panel.index')->name('panel');

//panel
Route::get('/', function () {
    return view('template');
});
//login
Route::get('/login', function () {
    return view('auth.login');
});

//errores de pagina
Route::get('/401', function () {
    return view('pages.401');
});
Route::get('/404', function () {
    return view('pages.404');
});
Route::get('/500', function () {
    return view('pages.500');
});

//moduloo de categorias
// Route::view('/categorias','categorias.index')->name('categoria');
Route::resource('categoria', categoriaController::class);