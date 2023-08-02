<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = ['texto', 'user_id', 'noticia_id'];

    // retorna el creador del comentario
    public function user() {
        return $this->belongsTo('\App\Models\User');
    }

    // retorna la noticia del comentario
    public function noticia() {
        return $this->belongsTo('\App\Models\Noticia');
    }
}
