<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function tiempoPublicado(){
        return $this->created_at->diffForHumans();
    }

   public function getHtmlMensajeAttribute()
{
    return Str::markdown($this->mensaje);
}

}