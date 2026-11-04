@extends('template.base')

@section('title')
Ver noticia
@endsection

@section('content')

<section class="page-section">
    <div class="container px-4 px-lg-5">

        <h2 class="text-center mt-0">
            {{ $noticia->titulo }}
        </h2>

        <p class="text-center">
            Publicado: {{ $noticia->tiempoPublicado() }}
        </p>

        <hr class="divider">

        <div class="card mb-4">
            <div class="card-body">

               <div class="card-text">
    {!! \Illuminate\Support\Str::markdown($noticia->texto) !!}
</div>

                <a href="{{ route('noticia.index') }}"
                   class="btn btn-secondary">
                    Volver
                </a>

                <a href="{{ route('noticia.edit', $noticia) }}"
                   class="btn btn-primary">
                    Editar
                </a>

            </div>
        </div>


        {{-- Comentarios --}}
        <h3>Comentarios</h3>

        @foreach($noticia->comentarios as $comentario)

            <div class="card mb-3">
                <div class="card-body">

                        <div>
    {!! \Illuminate\Support\Str::markdown($comentario->mensaje) !!}
</div>
                    <p>
                        Publicado: {{ $comentario->tiempoPublicado() }}
                    </p>

                    <p>
                        Valoración:
                        {{ $comentario->valoracion }}
                    </p>

                    <a href="{{ route('comentario.edit', $comentario) }}"
                       class="btn btn-secondary">
                        Editar comentario
                    </a>

                    <form
                        action="{{ route('comentario.destroy', $comentario) }}"
                        method="post"
                        style="display:inline">

                        @csrf
                        @method('delete')

                        <input
                            type="submit"
                            value="Borrar comentario"
                            class="btn btn-danger">

                    </form>

                </div>
            </div>

        @endforeach


        <hr>

        {{-- Crear comentario --}}
        <h3>Añadir comentario</h3>

        <form action="{{ route('comentario.store') }}"
              method="post"
              novalidate>

            @csrf

            <input
                type="hidden"
                name="noticia_id"
                value="{{ $noticia->id }}">

            <div class="mb-3">

                <label for="mensaje" class="form-label">
                    Mensaje:
                </label>

                <textarea
                    id="mensaje"
                    name="mensaje"
                    class="form-control"
                    rows="5">{{ old('mensaje') }}</textarea>

            </div>

            @error('mensaje')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror


            <div class="mb-3">

                <label for="valoracion" class="form-label">
                    Valoración:
                </label>

                <select
                    id="valoracion"
                    name="valoracion"
                    class="form-select">

                    <option value="">
                        Selecciona una valoración
                    </option>

                    <option value="pos"
                        @selected(old('valoracion') == 'pos')>
                        Positiva
                    </option>

                    <option value="neg"
                        @selected(old('valoracion') == 'neg')>
                        Negativa
                    </option>

                </select>

            </div>

            @error('valoracion')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror


            <button type="submit"
                    class="btn btn-primary">
                Añadir comentario
            </button>

        </form>

    </div>
</section>

@endsection
