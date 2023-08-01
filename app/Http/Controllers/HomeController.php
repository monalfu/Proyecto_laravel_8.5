<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // recuperar noticias
        $noticias = $request->user()->noticias()
            ->paginate(config('pagination.noticias', 5));

        // noticias borradas
        $deletedNoticias = $request->user()->noticias()->onlyTrashed()->paginate(config('pagination.noticias', 5))->get();

        // comentarios escritos
        $comentarios = $request->user()->comentarios()->paginate(config('pagination.comentarios', 5));

        return view('home', ['noticias' => $noticias, 'deletedNoticias' => $deletedNoticias, 'comentarios' => $comentarios]);
    }
}
