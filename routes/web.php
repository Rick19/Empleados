<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\PuestoController;
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

$controller_path = 'App\Http\Controllers';

// Main Page Route
Route::get('/', function () {
    return redirect()->route('empleados.index');
})->name('home');

/*
 * Rutas de recursos CRUD
 * (index, show, create, update, destroy, edit) -> php artisan route:list --path=companies para ver listado
 * edit y show se exceptuaron ya que se realizará desde el listado por ajax.
 * */
Route::resource('companies', CompanyController::class)->except(['edit', 'show']);
Route::patch('companies/reactivate/{company}', [CompanyController::class, 'restore'])->name('companies.restore');

Route::resource('puestos', PuestoController::class)->except(['edit', 'show']);
Route::patch('puestos/reactivate/{puesto}', [PuestoController::class, 'restore'])->name('puestos.restore');

Route::resource('empleados', EmpleadoController::class);
Route::patch('empleados/reactivate/{empleado}', [EmpleadoController::class, 'restore'])->name('empleados.restore');