<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\InsumoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PresentacionController;
use App\Http\Controllers\ServicioController;
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
Route::resource('compra', CompraController::class);
Route::resource('marca', MarcaController::class);
Route::resource('presentacion', PresentacionController::class);
Route::resource('entrega', EntregaController::class);


// Route::middleware('auth')->group(function (){
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

