<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\NoticiasController;
use App\Models\Noticia;


Route::controller(NoticiasController::class)->group(function() {

    // Página de listado noticias publicadas
    Route::get('/', 'index')
    ->name('noticias.index');

    // Página noticias no publicadas
    Route::get('/noticias/nopublicadas', 'noPublicadas')
        ->name('no_published.noticias');

    // Buscador noticias por título o tema
    Route::get('/noticias/search/{titulo?}/{tema?}', 'searchPublicadas')
        ->name('noticias.searchPublicadas');

    // Buscador noticias no publicadas por título o tema o redactor
    Route::get('/noticias/noPublicadas/search/{titulo?}/{tema?}/{name?}', 'searchNoPublicadas')
    ->name('noticias.searchNoPublicadas');

    // Creación noticias
    Route::get('/noticias/create', 'create')
        ->name('noticias.create')
        ->middleware('roleCheck:redactor');

    Route::get('noticias/borradas', 'noticiasBorradas')
        ->name('deleted.noticias');

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
    Route::get('/noticias/restore/{noticia}', 'restore')
        ->name('noticias.restore');

    // Confirmación borrado definitivo
    Route::get('/noticias/delete/{noticia}', 'delete')
        ->name('noticias.delete');

});

/*
Route::post('/guardarcomentario', [ComentarioController::class, 'store'])->name('comentarios.store');
*/
Route::controller(ContactoController::class)->group(function(){

    Route::get('/contacto', 'index')
            ->name('contacto');

    Route::post('/contacto', 'send')
            ->name('contacto.email');
});

Auth::routes(['verify'=>true]);

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
    Route::post('role', 'setRole')
    ->name('admin.user.setRole');

    // eliminar rol
    Route::delete('role', 'removeRole')
    ->name('admin.user.removeRole');
});

// ruta de usuarios bloqueados, HACER UserController
Route::get('/bloqueado', [UserController::class, 'blocked'])
    ->name('user.blocked');



Route::controller(ComentarioController::class)->group(function() {
    // Creación comentario
    Route::get('/comentarios/create', 'create')
    ->name('comentario.create');

    // Guardar noticia
    Route::post('/comentarios', 'store')
        ->name('comentarios.store');

    // Borrar comentario
    Route::get('/borrar/comentario/{comentario}', 'destroy')
        ->name('comentarios.destroy');

    // Confirmación borrado
    Route::get('/comentarios/{comentario}/delete', 'delete')
        ->name('comentarios.delete');
});

