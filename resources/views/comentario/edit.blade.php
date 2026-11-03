@extends('template.base')

@section('title')
Editar comentario
@endsection

@section('content')

<section class="page-section">
    <div class="container px-4 px-lg-5">

        <h2 class="text-center mt-0">
            Editar comentario
        </h2>

        <hr class="divider">

        <form action="{{ route('comentario.update', $comentario) }}"
              method="post"
              novalidate>

            @method('put')
            @csrf

            <input
                type="hidden"
                name="noticia_id"
                value="{{ $comentario->noticia_id }}">

            {{-- Mensaje --}}
            <div class="mb-3">

                <label for="mensaje" class="form-label">
                    Mensaje:
                </label>

                <textarea
                    id="mensaje"
                    name="mensaje"
                    class="form-control"
                    rows="5">{{ old('mensaje', $comentario->mensaje) }}</textarea>

            </div>

            @error('mensaje')
                <div class="alert alert-danger" role="alert">
                    {{ $message }}
                </div>
            @enderror


            {{-- Valoración --}}
            <div class="mb-3">

                <label for="valoracion" class="form-label">
                    Valoración:
                </label>

                <select
                    id="valoracion"
                    name="valoracion"
                    class="form-select">

                    <option value="pos"
                        @selected(old('valoracion', $comentario->valoracion) == 'pos')>
                        Positiva
                    </option>

                    <option value="neg"
                        @selected(old('valoracion', $comentario->valoracion) == 'neg')>
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
                Editar comentario
            </button>

        </form>

    </div>
</section>

@endsection