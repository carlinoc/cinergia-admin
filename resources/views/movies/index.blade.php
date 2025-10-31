@extends('adminlte::page')

@section('title', 'Películas')

@section('content_header')
    <h1 class="h1title">Listado de Películas</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="/movies/create" class="btn btn-primary">Nueva Película</a>
            </div>
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <x-adminlte-datatable id="dtmovies" :heads="$heads" class="hover">
                    @foreach($movies as $movie)
                        <tr>
                            <td>{{ $movie->id }}</td>
                            <td>{{ $movie->name }}</td>
                            <td>{{ $movie->category }}</td>
                            <td><div style="width:120px;"><img src="{{ $movie->image1 }}" class="img-fluid" /></div></td>
                            <td class="text-center">{{ $movie->views_count }}</td>
                            <td>
                                <a href="/movies/{{$movie->id}}/edit" class="btn btn-sm btn-info">Editar</a>

                                <form action="{{route('movies.destroy', $movie)}}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger deleteMovie"><i class="far fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </x-adminlte-datatable>
            </div>
        </x-adminlte-card>
    </div>
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    $(document).ready(function() {

        $('.deleteMovie').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Advertencia",
                text: "Deseas eliminar la pelicula y todos sus archivos relacionados?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    var form = $(this).parent();
                    $(form).submit();
                }
            });
        });

        @if (Session::get('success'))
            Swal.fire({
                title: "Atención",
                text: "{{Session::get('success')}}",
                icon: "success",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Aceptar"
            });
        @endif
    });
</script>
@stop
