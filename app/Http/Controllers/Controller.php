<?php

namespace App\Http\Controllers;

abstract class Controller
{
     // Este "Accessor" se activa automáticamente al usar $post->html_content
    public function getHtmlContentAttribute()
    {
        return Str::markdown($this->content);
    }
}
