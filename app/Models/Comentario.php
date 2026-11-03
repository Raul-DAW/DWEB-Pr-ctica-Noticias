<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
        'noticia_id',
        'mensaje',
        'valoracion'
    ];

    public function noticia()
    {
        return $this->belongsTo(Noticia::class);
    }
}