<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use \Exception;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ComentarioController extends Controller
{

    private const MESSAGES = [
         //Noticia
         'noticia_id.required' => 'La noticia es obligatoria',
         'noticia_id.numeric' => 'La noticia no se ha seleccionado bien',
         'noticia_id.exists' => 'La noticia no existe',

         //Mensaje
         'mensaje.required' => 'El mensaje es obligatorio',
         'mensaje.string' => 'El mensaje debe de ser una cadena de texto',
           
          //Valoración
          'valoracion.required'     => 'La valoracion es obligatoria',
           'valoracion.in'     => 'La valoracion seleccionada no es valida',
    ];

    private const RULES = [
       'noticia_id' => 'required|numeric|exists:noticias,id',
       'mensaje'    => 'required|string',
       'valoracion' => 'required|in:pos,neg',
    ];

    public function create(): View {
        return view('comentario.create', []);
    }
    
    public function destroy(Comentario $comentario): RedirectResponse {

     if($comentario->created_at->diffInMinutes(now()) >=5){

    return back()->withErrors([
        'error' => 'No se puede borrar el comentario después de 5 minutos'
    ]);
    }
        $noticiaId = $comentario->noticia_id;
        try {
            $comentario->delete();
        } catch(Exception $e) {
            return back()->withErrors(['error' => 'Error al borrar el comentario.',]);
        }
        return redirect()->route('noticia.show', $noticiaId)->with(['success' => 'Se ha borrado el comentario.']);
    }
        
    public function edit(Comentario $comentario): View {
        return view('comentario.edit', ['comentario' => $comentario]);
    }

    public function index(): View {
        $comentarios = Comentario::all();
        return view('comentario.index', ['comentarios' => $comentarios]);
    }

    public function show(Comentario $comentario): View {
        return view('comentario.show', ['comentario' => $comentario]);
    }
        
    public function store(Request $request): RedirectResponse {
        //1º validar
        $validator = Validator::make($request->all(), self::RULES, self::MESSAGES);
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }

        $comentario = new Comentario($request->all());
        try {
            $comentario->save();
        } catch(UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors([
                'error' => 'Comentario duplicado.',
            ]);
        } catch(Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al comentar.',]);
        }
        
        return redirect()->route('comentario.index')->with(['success' => 'Se ha creado el comentario correctamente']);
    }

    public function update(Request $request, Comentario $comentario): RedirectResponse {

    if($comentario->created_at->diffInMinutes(now()) >=5){

    return back()->withErrors([
        'error' => 'No se puede editar el comentario después de 5 minutos'
    ]);
    }


        $validator = Validator::make($request->all(), self::RULES, self::MESSAGES);
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }
        try {
            $comentario->update($request->all());
        } catch(UniqueConstraintViolationException $e) {
            return back()->withInput()->withErrors(['error' => 'Clave única duplicada.',]);
        } catch(Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Error al editar el comentario.',]);
        }
        return redirect()->route('comentario.index');
    }

}