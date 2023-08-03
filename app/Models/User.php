<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // noticias relacionadas con el usuario
    public function noticias() {
        return $this->hasMany('\App\Models\Noticia');
    }

    // comentarios relacionadas con el usuario
    public function comentarios() {
        return $this->hasMany('\App\Models\Comentario');
    }

    // recupera el rol del usuario
    public function roles() {
        return $this->belongsToMany('App\Models\Role');
    }

    public function hasRole($roleNames):bool {
        if(!is_array($roleNames))
            $roleNames = [$roleNames];

            // ¡¡NO FUNCIONA!!
        if(is_null($roleNames))
            $roleNames = ['invitado'];

            foreach($this->roles as $role) {
            if(in_array($role->role, $roleNames))
                return true;
        }

        return false;
    }

    public function remainingRoles() {
        $actualRoles = $this->roles; // user roles
        $allRoles = Role::all(); // todos los roles

        // retorna todos los roles menos los que ya tiene el usuario
        return $allRoles->diff($actualRoles);
    }

    public function isOwner(Noticia $noticia):bool {
        return $this->id == $noticia->user_id;
    }

    public function isNoOwner(Noticia $noticia):bool {
        return $this->id != $noticia->user_id;
    }

}
