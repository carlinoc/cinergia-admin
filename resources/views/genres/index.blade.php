@extends('adminlte::page')

@section('title', 'Categorías')

@section('content_header')
    <h1>Mantenimiento de Géneros</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="/genres/create" class="btn btn-primary">Crear Genero</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <x-adminlte-datatable id="dtgenres" :heads="$heads" class="hover">
                    @foreach($genres as $genre)
                        <tr>
                            <td>{{ $genre->id }}</td>
                            <td>{{ $genre->name }}</td>
                            <td>{{ $genre->slug }}</td>
                            <td>
                                <a href="/genres/{{$genre->id}}/edit" class="btn btn-sm btn-info">Editar</a>

                                <form action="{{route('genres.destroy', $genre)}}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger deleteGenre"><i class="far fa-trash-alt"></i></button>
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
<script>
    $(document).ready(function() {

        $('.deleteGenre').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Advertencia",
                text: "Deseas eliminar el genero?",
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
                title: "Géneros",
                text: "{{Session::get('success')}}",
                icon: "success",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Aceptar"
            });
        @endif
    });    
</script>
@stop