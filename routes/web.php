<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\InsumoCaracteristicaController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\KardexController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\UsuarioController;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Route;
use JeroenNoten\LaravelAdminLte\View\Components\Widget\ProfileColItem;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'index']);
Route::resource('categoria', CategoriaController::class);
Route::resource('servicio', ServicioController::class);
Route::resource('insumo', InsumoController::class);
Route::resource('marca', MarcaController::class);
Route::resource('presentacion', PresentacionController::class);
Route::resource('entrega', EntregaController::class);
Route::resource('proveedor', ProveedorController::class);
Route::resource('compra', CompraController::class);
Route::resource('perfil', PerfilController::class);
Route::resource('usuario', UsuarioController::class);
Route::resource('rol', RolController::class);
Route::resource('permiso', PermisoController::class);
Route::resource('kardex', KardexController::class);





Route::get('/insumo/search', [InsumoController::class, 'search'])->name('insumo.search');
Route::get('/get-stock', [EntregaController::class, 'getStock'])->name('get-stock');
Route::get('/get-caracteristicas', [EntregaController::class, 'getCaracteristicas']);
Route::get('/insumo/{insumoId}/caracteristica/{caracteristicaId}/edit', 'App\Http\Controllers\InsumoCaracteristicaController@edit');
Route::patch('/insumo/{insumoId}/caracteristica/{caracteristicaId}', [InsumoCaracteristicaController::class, 'update'])->name('caracteristica.update');
