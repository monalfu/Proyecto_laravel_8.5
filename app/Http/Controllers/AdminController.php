<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Models\Noticia;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\QueryException;

class AdminController extends Controller
{
    // lista de usuarios
    public function userList() {
        $users = User::orderBy('name', 'ASC')
            ->paginate(config('pagination.users, 10'));

        return view('admin.users.list', ['users' => $users]);
    }

    // mostrar un usuario
    public function userShow(Request $request, User $user) {
        $noticias = $request->user->noticias;

        $deletedNoticias = $request->user->noticias()->onlyTrashed()->get();

        return view('admin.users.show', ['user' => $user, 'noticias' => $noticias, 'deletedNoticias' => $deletedNoticias]);
    }

    // búsqueda de usuarios
    public function userSearch(Request $request) {
        $name = $request->input('name', '');
        $email = $request->input('email', '');

        $users = User::orderBy('name', 'ASC')
            ->where('name', 'like', "%$name%")
            ->where('email', 'like', "%$email%")
            ->paginate(config('pagination.users'))
            ->appends(['name' => $name, 'email' => $email]);

        return view('admin.users.list', ['users' => $users, 'name' => $name, 'email' => $email]);
    }

    // añadir rol
    public function setRole(Request $request) {
        $role = Role::find($request->input('role_id'));
        $user = User::find($request->input('user_id'));

        try {
            $user->roles()->attach($role->id, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
            return back()
                ->with('success', "Rol $role->role añadido a $user->name correctamente");
        } catch(QueryException $e) {
            return back()
                ->withErrors("No se ha podido añadir el rol $role->role a $user->name. Es posible que ya lo tenga.");
        }
    }

    // borrar rol
    public function removeRole(Request $request) {
        $role = Role::find($request->input('role_id'));
        $user = User::find($request->input('user_id'));

        try {
            $user->roles()->detach($role->id);
            return back()
                ->with('success', "Rol $role->role quitado a $user->name correctamente.");
        } catch (QueryException $e) {
            return back()
                ->withErrors("No se pudo quitar el rol $role->role a $user->name. Probablemente no tenga ese rol.");
        }
    }
}

