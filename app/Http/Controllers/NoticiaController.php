<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use \Exception;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class NoticiaController extends Controller
{

    private const MESSAGES = [
         //Título
         'titulo.max'     => 'El titulo no puede superar los 255 caracteres',
          'titulo.required'     => 'El titulo es obligatorio',
           'titulo.string'     => 'El titulo debe de ser una cadena de texto',

           //Texto
          'texto.required'     => 'El texto es obligatorio',
           'texto.string'     => 'El texto debe de ser una cadena de texto',
    ];

    private const RULES = [
        'titulo'    => 'required|string|max:255',
        'texto' => 'required|string',
    ];

    public function create(): View {
        return view('noticia.create', []);
    }
    
    public function destroy(Noticia $noticia): RedirectResponse {

    if($noticia->comentarios()->count() > 0){
        return back()->withErrors([
            'error' => 'No se puede borrar una noticia que tiene comentarios'
        ]);
    }

        try {
            $noticia->delete();
        } catch(Exception $e) {
            return back()->withErrors(['error' => 'Error al borrar la noticia.',]);
        }
        return redirect()->route('noticia.index')->with(['success' => 'Se ha borrado la noticia.']);
    }
        
    public function edit(Noticia $noticia): View {
        return view('noticia.edit', ['noticia' => $noticia]);
    }

    public function index(): View {
        $noticias = Noticia::all();
        return view('noticia.index', ['noticias' => $noticias]);
    }

    public function show(Noticia $noticia): View {
        return view('noticia.show', ['noticia' => $noticia]);
    }
        
    public function store(Request $request): RedirectResponse {
        //1º validar
        $validator = Validator::make($request->all(), self::RULES, self::MESSAGES);
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $noticia = new Noticia($request->all());
        try {
            $noticia->save();
        } catch(UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors([
                'error' => 'Titulo duplicado.',
            ]);
        } catch(Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al crear la noticia.',]);
        }
        
        return redirect()->route('noticia.index')->with(['success' => 'Se ha creado la noticia correctamente']);
    }

    public function update(Request $request, Noticia $noticia): RedirectResponse {

      if($noticia->created_at->diffInMinutes(now()) >=20){

    return back()->withErrors([
        'error' => 'No se puede editar la noticia después de 20 minutos'
    ]);
    }

        $validator = Validator::make($request->all(), self::RULES, self::MESSAGES);
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        try {
            $noticia->update($request->all());
        } catch(UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors(['error' => 'Clave única duplicada.',]);
        } catch(Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al editar la noticia.',]);
        }
        return redirect()->route('noticia.index');
    }

}