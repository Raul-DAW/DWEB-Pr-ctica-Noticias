<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $fillable = [
        'titulo',
        'texto'
    ];

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}