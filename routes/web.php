<?php

use App\Http\Controllers\categoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\marcaController;
use App\Http\Controllers\presentacionesController;
use App\Http\Controllers\productoController;
use App\Http\Controllers\ProveedoresController;
use App\Http\Controllers\VentaController;
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
/*Por si se genera un error en otros posibles proyectos cuando se crea el controlador con --resource
y solo tenemos esta ruta lo podemos corregir con esto
Route::resource('categoria', categoriaController::class);*/

Route::resource('categoria', CategoriaController::class)->parameters([
    'categoria' => 'categoria'
]);

//modulo marcas
Route::resource('marca', marcaController::class)->parameters([
    'marca' => 'marca'
]);

//modulo presentaciones
Route::resource('presentaciones', presentacionesController::class)->parameters([
    'presentaciones' => 'presentaciones'
]);

//modulo productos
Route::resource('producto', productoController::class)->parameters([
    'producto' => 'producto'
]);

//modulo clientes
Route::resource('cliente', ClienteController::class)->parameters([
    'cliente' => 'cliente'
]);


//modulo proveedores
Route::resource('proveedores', ProveedoresController::class)->parameters([
    'proveedores' => 'proveedores'
]);

//modulo compra
Route::resource('compras',  ComprasController::class)->parameters([
    'compras' => 'compras'
]);

Route::resource('venta',  VentaController::class)->parameters([
    'venta' => 'venta'
]);