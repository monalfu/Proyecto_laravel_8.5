<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Noticia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['titulo', 'tema', 'texto', 'imagen', 'user_id', 'rejected'];

    // retorna el redactor de la noticia
    public function user() {
        return $this->belongsTo('\App\Models\User');
    }

    public function comentarios() {
        return $this->hasMany(Comentario::class);
    }
}
