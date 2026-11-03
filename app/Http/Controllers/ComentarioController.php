<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;


class ComentarioController extends Controller
{

  private const RULES = [
        'noticia_id' => 'required|exists:noticias,id',
        'mensaje' => 'required|string',
        'valoracion' => 'required|in:pos,neg'
    ];

    private const MESSAGES = [
        'noticia_id.required' => 'La noticia es obligatoria.',
        'noticia_id.exists' => 'La noticia seleccionada no existe.',

        'mensaje.required' => 'El mensaje es obligatorio.',
        'mensaje.string' => 'El mensaje debe ser una cadena de texto.',

        'valoracion.required' => 'La valoración es obligatoria.',
        'valoracion.in' => 'La valoración seleccionada no es válida.'
    ];

    /**
     * Display a listing of the resource.
     */
    public function index(): View{
         $comentarios = Comentario::all();

        return view('comentario.index', [
            'comentarios' => $comentarios
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View {
         return view('comentario.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse{
         $validator = Validator::make(
            $request->all(),
            self::RULES,
            self::MESSAGES
        );

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $comentario = new Comentario($request->all());
        $comentario->save();

        return redirect()
            ->route('noticia.show', $comentario->noticia_id)
            ->with([
                'success' => 'Se ha creado el comentario correctamente'
            ]); 
    }

    /**
     * Display the specified resource.
     */
    public function show(Comentario $comentario): View
    {
           return view('comentario.show', [
            'comentario' => $comentario
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comentario $comentario): View
    {
         return view('comentario.edit', [
            'comentario' => $comentario
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comentario $comentario): RedirectResponse {
        $validator = Validator::make(
            $request->all(),
            self::RULES,
            self::MESSAGES
        );

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator);
        }

        $comentario->update($request->all());

        return redirect()
            ->route('noticia.show', $comentario->noticia_id)
            ->with([
                'success' => 'Se ha editado el comentario correctamente'
            ]);
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comentario $comentario): RedirectResponse {
                $noticiaId = $comentario->noticia_id;

        $comentario->delete();

        return redirect()
            ->route('noticia.show', $noticiaId)
            ->with([
                'success' => 'Se ha borrado el comentario correctamente'
            ]);
    }
}
