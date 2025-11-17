@extends('adminlte::page')

@section('title', 'Categorías')

@section('content_header')
    <h1>Mantenimiento de Directores</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="/directors/create" class="btn btn-primary">Crear Director</a>
            </div>
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <x-adminlte-datatable id="dtdirectors" :heads="$heads" class="hover" :config="['order' => [[1, 'asc']]]">
                    @foreach($directors as $director)
                        <tr>
                            <td>{{ $director->id }}</td>
                            <td>{{ $director->firstName }}</td>
                            <td>{{ $director->lastName }}</td>
                            <td>{{ $director->country }}</td>
                            <td>
                                <a href="/directors/{{$director->id}}/edit" class="btn btn-sm btn-info">Editar</a>

                                <form action="{{route('directors.destroy', $director)}}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger deleteDirector"><i class="far fa-trash-alt"></i></button>
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

        $('.deleteDirector').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Advertencia",
                text: "Deseas eliminar el director?",
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
                title: "Directores",
                text: "{{Session::get('success')}}",
                icon: "success",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Aceptar"
            });
        @endif
    });
</script>
@stop
