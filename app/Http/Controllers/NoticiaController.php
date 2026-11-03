<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class NoticiaController extends Controller
{

private const RULES = [
        'titulo' => 'required|string|max:255',
        'texto' => 'required|string'
    ];

    private const MESSAGES = [
        'titulo.required' => 'El título es obligatorio.',
        'titulo.string' => 'El título debe ser una cadena de texto.',
        'titulo.max' => 'El título no puede superar los 255 caracteres.',

        'texto.required' => 'El texto es obligatorio.',
        'texto.string' => 'El texto debe ser una cadena de texto.',
    ];

    /**
     * Display a listing of the resource.
     */
    public function index():View {
           $noticias = Noticia::all();

        return view('noticia.index', [
            'noticias' => $noticias
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View{
        return view('noticia.create');
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

        $noticia = new Noticia($request->all());
        $noticia->save();

        return redirect()
            ->route('noticia.index')
            ->with([
                'success' => 'Se ha creado la noticia correctamente'
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Noticia $noticia): View{
           return view('noticia.show', [
            'noticia' => $noticia
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Noticia $noticia): View{
          return view('noticia.edit', [
            'noticia' => $noticia
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Noticia $noticia): RedirectResponse {
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

        $noticia->update($request->all());

        return redirect()
            ->route('noticia.index')
            ->with([
                'success' => 'Se ha editado la noticia correctamente'
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noticia $noticia): RedirectResponse{
           $noticia->delete();

        return redirect()
            ->route('noticia.index')
            ->with([
                'success' => 'Se ha borrado la noticia correctamente'
            ]);
    }
}
