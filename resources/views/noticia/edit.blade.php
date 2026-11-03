@extends('template.base')

@section('title')
Editar noticia
@endsection

@section('content')

<section class="page-section">
    <div class="container px-4 px-lg-5">

        <h2 class="text-center mt-0">
            Editar noticia
        </h2>

        <hr class="divider">

        <form action="{{ route('noticia.update', $noticia) }}"
              method="post"
              novalidate>

            @method('put')
            @csrf

            {{-- Título --}}
            <div class="mb-3">
                <label for="titulo" class="form-label">
                    Título:
                </label>

                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    class="form-control"
                    value="{{ old('titulo', $noticia->titulo) }}">
            </div>

            @error('titulo')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror


            {{-- Texto --}}
            <div class="mb-3">
                <label for="texto" class="form-label">
                    Texto:
                </label>

                <textarea
                    id="texto"
                    name="texto"
                    class="form-control"
                    rows="8">{{ old('texto', $noticia->texto) }}</textarea>
            </div>

            @error('texto')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror


            <button type="submit" class="btn btn-primary">
                Editar noticia
            </button>

        </form>

    </div>
</section>

@endsection