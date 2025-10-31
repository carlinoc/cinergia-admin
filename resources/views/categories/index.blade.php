@extends('adminlte::page')

@section('title', 'Categorías')

@section('content_header')
    <h1>Mantenimiento de Categorías</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="/categories/create" class="btn btn-primary">Crear Categoría</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <x-adminlte-datatable id="dtCategories" :heads="$heads" class="hover">
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>
                                <a href="/categories/{{$category->id}}/edit" class="btn btn-sm btn-info">Editar</a>

                                <form action="{{route('categories.destroy', $category)}}" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger deleteCategory"><i class="far fa-trash-alt"></i></button>
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

        $('.deleteCategory').on('click', function(e) {
            e.preventDefault();

            Swal.fire({
                title: "Advertencia",
                text: "Deseas eliminar la categoría?",
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
                title: "Categorías",
                text: "{{Session::get('success')}}",
                icon: "success",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Aceptar"
            });
        @endif
    });    
</script>    
@stop