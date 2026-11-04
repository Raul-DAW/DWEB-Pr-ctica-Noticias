<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    public function tiempoPublicado(){
        return $this->created_at->diffForHumans();
    }

    public function getHtmlContenidoAttribute()
{
    return Str::markdown($this->texto);
}
}