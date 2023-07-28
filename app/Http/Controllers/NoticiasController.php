<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;

// autorizaciones en formRequest o aquí mismo
// hacer policies: restore, delete
// hacer componente para mensajes de alert

class NoticiasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticias = Noticia::orderBy('id','DESC')->paginate(config('pagination.dulces'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Noticia $noticia)
    {
        $noticia->delete();

        return redirect('/noticias');
    }

    // método de restaurar noticia borrada
    public function restore(Request $request, int $id) {
        // recupera la noticia borrada
        $noticia = Noticia::withTrashed()->findOrFail($id);

        if($request->user()->cant('restore', $noticia))
            throw new AuthorizationException('No tienes permiso');

        // restaura la noticia
        $noticia->restore();

        return back()->with('success', "Noticia $noticia->titulo restaurado correctamente.");
    }

    // Método para eliminar la noticia definitivamente
    public function purge(Request $request) {
        $noticia = Noticia::withTrashed()->findOrFail($request->input('noticia_id'));

        // comprobar permisos mediante la policy (FALTA HACER)
        if($request->user()->cant('delete', $noticia));
            throw new AuthorizationException('No tienes permiso.');

        // eliminar imagen si se puede eliminar
        if($noticia->forceDelete() && $noticia->imagen)
            Storage::delete(config('filesystems.noticiasImageDir').'/'.$noticia->imagen);

        return back()->with('success', "Noticia $noticia->titulo eliminada correctamente.");
    }
}
