<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NoticiasController;



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
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::controller(NoticiasController::class)->group(function() {
    // Página de listado noticias publicadas
    Route::get('/', 'index')
        ->name('noticias.index');

    // Buscador noticias por título o tema
    Route::get('/noticias/search/{titulo?}/{tema?}')
        ->name('noticias.search');

    // Creación noticias
    Route::get('/noticias/create', 'create')
        ->name('noticias.create');

    // Detalles de una noticia
    Route::get('/noticias/{noticia}', 'show')
        ->name('noticias.show');

    // Guardar noticia
    Route::post('/noticias', 'store')
        ->name('noticias.store');

    // Editar noticia
    Route::get('/noticias/{noticia}/edit', 'edit')
        ->name('noticias.edit');

    // Actualización de noticia
    Route::match(['PUT', 'PATCH'], 'noticias/{noticia}', 'update')
        ->name('noticias.update');

    // Softdelete
    Route::get('/borrar/noticia/{noticia}', 'destroy')
        ->name('noticias.destroy');

    // Eliminar definitivamente
    Route::delete('/noticias/purge', 'purge')
        ->name('noticias.purge');

    // Restauración noticia eliminada
    Route::get('/noticias/{noticia}/restore', 'restore')
        ->name('noticias.restore');

    // Confirmación borrado definitivo
    Route::get('/noticias/{noticia}/delete', 'delete')
        ->name('noticias.delete');

    Route::get('noticias/borradas')
        ->name('deleted.noticias');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->controller(AdminController::class)->middleware('auth', 'is_admin')->group(function() {
    // noticias eliminadas
    Route::get('deletednoticias', 'deletedNoticias')
        ->name('admin.deleted.noticias');

    // detalles usuario
    Route::get('usuario/{user}/detalles', 'userShow')
    ->name('admin.user.show');

    // listado usuarios
    Route::get('usuarios', 'userList')
    ->name('admin.users');

    // búsqueda usuarios
    Route::get('usuario/buscar', 'userSearch')
    ->name('admin.users.search');

    // añadir rol
    Route::get('role', 'setRole')
    ->name('admin.user.setRole');

    // eliminar rol
    Route::get('role', 'removeRole')
    ->name('admin.user.removeRole');
});

// ruta de usuarios bloqueados, HACER UserController
Route::get('/bloqueado', [UserController::class, 'blocked'])
    ->name('user.blocked');
