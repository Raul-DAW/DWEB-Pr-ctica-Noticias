@extends('template.base')

@section('title')
Comentarios
@endsection

@section('content')

<section class="page-section">
    <div class="container px-4 px-lg-5">

        <h2 class="text-center mt-0">
            Comentarios
        </h2>

        <hr class="divider">

        @foreach($comentarios as $comentario)

            <div class="card mb-3">
                <div class="card-body">

                    <p>
                        {{ $comentario->mensaje }}
                    </p>

                    <p>
                        Valoración:
                        {{ $comentario->valoracion }}
                    </p>

                    <p>
                        Noticia:
                        {{ $comentario->noticia_id }}
                    </p>

                    <a href="{{ route('comentario.edit', $comentario) }}"
                       class="btn btn-secondary">
                        Editar
                    </a>

                    <form action="{{ route('comentario.destroy', $comentario) }}"
                          method="post"
                          style="display:inline">

                        @csrf
                        @method('delete')

                        <input
                            type="submit"
                            value="Borrar"
                            class="btn btn-danger">

                    </form>

                </div>
            </div>

        @endforeach

    </div>
</section>

@endsection