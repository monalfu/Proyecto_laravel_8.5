<?php

namespace App\Http\Controllers;


use App\Models\Noticia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Routing\Controller;
use PHPUnit\Framework\Error\Notice;

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
    public function index()
    {
        $noticias = Noticia::orderBy('id','DESC')
            ->whereNotNull('published_at')
            ->paginate(config('pagination.noticias', 10));


        return view('noticias.list', ['noticias'=>$noticias]);

    }

    public function noPublicadas()
    {
        $noticias = Noticia::orderBy('id','DESC')
            ->whereNull('published_at')
            ->paginate(config('pagination.noticias', 10));

        return view('noticias.listNoPublicadas', ['noticias'=>$noticias]);
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
    public function show(Noticia $noticia)
    {
        // comentarios escritos
        $comentarios = $noticia->comentarios()->paginate(config('pagination.comentarios', 4));

        // usuario identificado
        $authUser = auth()->user();

        // incremento +1 cada vez que se abre la noticia publicada y no es el redactor quien la abre
        /*if($noticia->published_at != null && $authUser != $noticia->user_id)
            $noticia->increment('visitas', 1);*/

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
        // VALIDACIÓN

        $datosNoticia = $request->all();

        if($request->hasFile('imagen')) {
            $imagenNueva = $request->file('imagen')->store(config('filesystems.noticiasImageDir'));

            Storage::delete(config('filesystems.noticiasImageDir') . '/' . $noticia->imagen);

            $datosNoticia['imagen'] = pathinfo($imagenNueva, PATHINFO_BASENAME);

        $noticia->update($datosNoticia);

        return back()
            ->with(
                'success',
                "La noticia $noticia->titulo ha sido actualizada.");
        }
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

        return redirect('/')
            ->with(
                'success',
                "Noticia $noticia->titulo eliminada correctamente."
            );
    }

    public function search(Request $request, $titulo = null, $tema = null) {
        $titulo = $titulo ?? $request->input('titulo', '');
        $tema = $tema ?? $request->input('tema', '');

        $noticias = Noticia::where('titulo', 'like', "%$titulo%")
            ->where('tema', 'like', '%$tema%')
            ->paginate(config('paginator.noticias', 5))
            ->appends(['titulo' => $titulo, 'tema' => $tema]);

        return view('noticias.list', ['noticias' => $noticias, 'titulo' => $titulo, 'tema' => $tema]);
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

    public function delete(Request $request, Noticia $noticia)
    {
        // HACER POLICI
        $request->user()->can('delete', $noticia);

        return view('noticias.delete', ['noticia'=>$noticia]);
    }
}
