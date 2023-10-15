<?php

namespace App\Http\Controllers;


use App\Models\Noticia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Routing\Controller;

// autorizaciones en formRequest o aquí mismo
// hacer policies: restore, delete
// hacer componente para mensajes de alert

class NoticiasController extends Controller
{
    public function __construct() {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // Lista noticias publicadas y muestra en página principal
    public function index()
    {
        $noticias = Noticia::orderBy('id','DESC')
            ->where('published', 1)
            ->paginate(config('pagination.noticias', 10));

        return view('noticias.list', ['noticias'=>$noticias]);
    }

    // Método que lista las noticias no publicadas y vuestra la vista
    public function noPublicadas()
    {
        $noticias = Noticia::orderBy('id','DESC')
            ->where('published', 0)
            ->paginate(config('pagination.noticias', 10));

        return view('noticias.listNoPublicadas', ['noticias'=>$noticias]);
    }

    public function noticiasBorradas()
    {
        $noticias = Noticia::orderBy('id','DESC')
            ->where('deleted_at', '>', 0)
            ->withTrashed()
            ->paginate(config('pagination.noticias', 10));

        return view('noticias.deleted', ['noticias'=>$noticias]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('noticias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $datosNoticia = $request->only('titulo', 'tema', 'texto', 'imagen');

        // recuperación imagen
        if($request->hasFile('imagen')) {
            $ruta = $request->file('imagen')->store(config('filesystems.noticiasImageDir'));

            $datosNoticia['imagen'] = pathinfo($ruta, PATHINFO_BASENAME);
        }

        // recupera el id del usuario identificado para añadirlo a la BDD
        $datosNoticia['user_id'] = $request->user()->id;

        // creación y guardado
        $noticia = Noticia::create($datosNoticia);

        // redirección a la noticia completa creada
        return redirect()
            ->route('noticias.show', $noticia->id)
            ->with('success', "Noticia $noticia->titulo añadida satisfactoriamente, pendiente de publicar por parte del editor.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Noticia $noticia, User $user)
    {
        // comentarios escritos
        $comentarios = $noticia->comentarios()->paginate(config('pagination.comentarios', 4));

        // id usuario identificado
        $authId = auth()->id();

        // Si la noticia está publicada y no la visualiza el creador incrementar en 1 las visitas
        if($noticia->published_at && $noticia->user_id != $authId)
            $noticia->increment('visitas', 1);

        return view('noticias.show', ['noticia'=>$noticia, 'comentarios'=>$comentarios]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Noticia $noticia)
    {
        // HACER POLICY
        if($request->user()->cant('update', $noticia))
            abort(401, 'No puedes editar esta noticia');

        return view('noticias.update', ['noticia'=>$noticia]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Noticia $noticia)
    {
        $datosNoticia = $request->all() + ['published' => 0, 'rejected' => 0];
        
        if($request->hasFile('imagen')) {
            $imagenNueva = $request->file('imagen')->store(config('filesystems.noticiasImageDir'));
            
            Storage::delete(config('filesystems.noticiasImageDir') . '/' . $noticia->imagen);
            
            $datosNoticia['imagen'] = pathinfo($imagenNueva, PATHINFO_BASENAME);
        }

        $noticia->update($datosNoticia);

        return back()
            ->with(
                'success',
                "La noticia $noticia->titulo ha sido actualizada."
            );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // Soft delete, método para eliminar pero no de la base de datos
     public function destroy(Noticia $noticia)
    {
        $noticia->delete();

        return back()
            ->with(
                'success',
                "Noticia $noticia->titulo eliminada correctamente."
            );
    }

    // Método de búsqueda de noticias. REVISAR para que busque según listado
    public function searchPublicadas(Request $request, $titulo = null, $tema = null) {
        $titulo = $titulo ?? $request->input('titulo', '');
        $tema = $tema ?? $request->input('tema', '');

        $noticias = Noticia::where('titulo', 'like', "%$titulo%")
            ->where('tema', 'like', "%$tema%")
            ->where('published', '=', 1)
            ->paginate(config('paginator.noticias', 5))
            ->appends(['titulo' => $titulo, 'tema' => $tema]);

        return view('noticias.list', ['noticias' => $noticias, 'titulo' => $titulo, 'tema' => $tema]);
    }

    // Método de búsqueda de noticias. REVISAR para que busque según listado
    public function searchNoPublicadas(Request $request, $titulo = null, $tema = null, $redactor = null) {
        $titulo = $titulo ?? $request->input('titulo', '');
        $tema = $tema ?? $request->input('tema', '');
        $redactor = $redactor ?? $request->input('name', '');
        
        
        $noticias = Noticia::where('titulo', 'like', "%$titulo%")
            ->where('noticias.tema', 'like', "%$tema%")
            ->where('noticias.published', '=', 0)
            ->join('users', 'users.id', '=', 'noticias.user_id')
            ->where('users.name', 'LIKE', "%$redactor%")
            ->paginate(config('paginator.noticias', 5))
            ->appends(['titulo' => $titulo, 'tema' => $tema, 'name' => $redactor]);

    return view('noticias.listNoPublicadas', ['noticias' => $noticias, 'titulo' => $titulo, 'tema' => $tema /*, 'name' => $redactor*/]);
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

    // Confirmación para eliminar al querer realizar el purge
    public function delete(Request $request, Noticia $noticia)
    {
    
        //$request->user()->can('delete', $noticia);

        return view('noticias.delete', ['noticia'=>$noticia]);
    }
}
