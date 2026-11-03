@extends('template.base')

@section('title')
Noticias
@endsection

@section('content')

<section class="page-section">
    <div class="container px-4 px-lg-5">

        <div class="text-end mb-4">
            <a href="{{ route('noticia.create') }}"
               class="btn btn-primary">
                Crear noticia
            </a>
        </div>

        <h2 class="text-center mt-0">
            Noticias
        </h2>

        <hr class="divider">

        @foreach($noticias as $noticia)

            <div class="card mb-3">
                <div class="card-body">

                    <h3 class="card-title">
                        {{ $noticia->titulo }}
                    </h3>

                    <p class="card-text">
                        {{ $noticia->texto }}
                    </p>

                    <a href="{{ route('noticia.show', $noticia) }}"
                       class="btn btn-secondary">
                        View
                    </a>

                    <a href="{{ route('noticia.edit', $noticia) }}"
                       class="btn btn-secondary">
                        Edit
                    </a>

                    <form
                        action="{{ route('noticia.destroy', $noticia) }}"
                        method="post"
                        style="display:inline">

                        @csrf
                        @method('delete')

                        <input
                            type="submit"
                            value="Delete"
                            class="btn btn-danger">

                    </form>

                </div>
            </div>

        @endforeach

    </div>
</section>

@endsection