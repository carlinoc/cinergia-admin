@extends('adminlte::page')

@section('title', 'Peliculas Rentadas')

@section('content_header')
    <h1>Peliculas Rentadas</h1>
@stop

@section('content')
    <div>
        <x-adminlte-card >
            <div class="card-body">
                <table id="dtMovieRented" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Pelicula</th>
                            <th>BuyerId</th>
                            <th>CulqiId</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){

        function fetch() {
            $.ajax({
                url: "{{ route('movierented.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    $('#dtMovieRented').DataTable({
                        "data": data.rented,
                        "responsive": true,
                        order: [[0, 'desc']],
                        "columns": [
                            {
                                "data": "id",
                                "render": function(data, type, row, meta) {
                                    return row.id;
                                }
                            },
                            {
                                "data": "movie",
                                "render": function(data, type, row, meta) {
                                    return row.movieId;
                                }
                            },
                            {
                                "data": "buyerId",
                                "render": function(data, type, row, meta) {
                                    return row.buyerId;
                                }
                            },
                            {
                                "data": "culquiId",
                                "render": function(data, type, row, meta) {
                                    return row.culqiId;
                                }
                            },
                            {
                                "data": "buyerDate",
                                "render": function(data, type, row, meta) {
                                    return row.buyerDate;
                                }
                            },
                            {
                                "data": "expireDate",
                                "render": function(data, type, row, meta) {
                                    return row.expireDate;
                                }
                            },
                            {
                                "data": null,
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" class="btn btn-sm btn-info detailHSection">Detalle</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeHSection"><i class="far fa-trash-alt"></i></a>';
                                },
                                "targets": -1
                            }
                        ]
                    });
                }
            });
        }
        fetch();
    }); 
</script>    
@stop