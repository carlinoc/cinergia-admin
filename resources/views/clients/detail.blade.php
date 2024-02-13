@extends('adminlte::page')

@section('title', 'Editar Cliente')

@section('content_header')
<div class="row">
    <div class="col-md-auto">
        <h1>Cliente: {{$client->name}}</h1>    
    </div>
    <div class="col">
        <a href="{{route('clients.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
    </div>
</div>    
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <form action="" method="POST" id="frmEditClient">
                        <input type="hidden" id="clientId" name="clientId" value="{{$client->id}}">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="slogan">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" disabled value="{{$client->name}}">
                            </div>
                            <div class="form-group">
                                <label for="slogan">Email</label>
                                <input type="text" class="form-control" id="email" name="email" disabled value="{{$client->email}}">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    @if($client->active == 0)         
                                    <input type="checkbox" class="custom-control-input" id="active" name="active">
                                    @else
                                    <input type="checkbox" class="custom-control-input" id="active" name="active" checked>
                                    @endif
                                    <label class="custom-control-label" for="active">Cliente activo</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="button" id="editClient" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" id="frmAddMovie">
                        <div class="row">
                            <div class="col-sm-6">
                                <input type="hidden" id="clientId" name="clientId" value="{{$client->id}}">
                                <x-adminlte-select2 name="movieId" data-placeholder="Seleccione">
                                    <option value=""></option>
                                    @foreach($movies as $movie)
                                        <option data-image1="{{$movie->image1}}" data-image2="{{$movie->image2}}" value="{{$movie->id}}">{{$movie->name}}</option>
                                    @endforeach
                                </x-adminlte-select2>
                            </div>        
                            <div class="col-sm-6">
                                <button type="button" id="addMovie" class="btn btn-info">Agregar Película</button>
                            </div>
                        </div>
                        </form>
                        <div class="row">
                            <div class="card-body">
                                <table id="dtMovies" class="row-border" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Película</th>
                                            <th>Nro Pago</th>
                                            <th>Tipo Pago</th>
                                            <th>Precio</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Estado</th>
                                            <th>opciones</th>
                                        </tr>
                                    </thead>
                                </table>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
@stop

@section('css')
<style>
label:not(.form-check-label):not(.custom-file-label) {
    font-weight: 500;
}
</style>    
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    $(document).ready(function(){

        function fetch() {
            let clientId = $("#clientId").val();
            $.ajax({
                url: "{{ route('clients.movielist') }}",
                type: "Get",
                data: {clientId:clientId},
                dataType: "json",
                success: function(data) {
                    $('#dtMovies').DataTable({
                        "data": data.movies,
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
                                "data": "name",
                                "render": function(data, type, row, meta) {
                                    return row.name;
                                }
                            },
                            {
                                "data": "transactionId",
                                "render": function(data, type, row, meta) {
                                    return row.transactionId;
                                }
                            },
                            {
                                "data": "payment_type",
                                "render": function(data, type, row, meta) {
                                    return row.payment_type;
                                }
                            },
                            {
                                "data": "amount",
                                "render": function(data, type, row, meta) {
                                    return row.amount;
                                }
                            },
                            {
                                "data": "date_start",
                                "render": function(data, type, row, meta) {
                                    var date = new Date(row.date_start).toLocaleDateString();
                                    return date;
                                }
                            },
                            {
                                "data": "date_end",
                                "render": function(data, type, row, meta) {
                                    var date = new Date(row.date_end).toLocaleDateString();
                                    return date;
                                }
                            },
                            {
                                "data": null,
                                "render": function(data, type, row, meta) {
                                    var date1 = new Date();
                                    console.log(date1);
                                    var date2 = new Date(row.date_end);
                                    console.log(date2);
                                    return (date1>=date2?'<small class="badge badge-secondary">Expirado</small>':'<small class="badge badge-success">Activo</small>');
                                }
                            },
                            {
                                "data": null,
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeMovie"><i class="far fa-trash-alt"></i></a>';
                                },
                                "targets": -1
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#addMovie').on('click', function(e) {
            e.preventDefault();
            let movieId = $('#movieId').val();
            if(movieId!=""){
                var myform = document.getElementById('frmAddMovie');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                $.ajax({
                    url:"{{ route('clients.addmovie') }}",
                    method:'post',
                    data:form,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success:function(res){
                        if(res.status=="success"){
                            $("#movieId").val("").change();
                            $('#dtMovies').DataTable().destroy();
                            fetch();
                        }
                        if(res.status=="error"){
                            Swal.fire({
                            title: "Oops",
                            text: res.message,
                            icon: "warning"
                            });
                        }    
                    },error:function(err){
                        alert(err);
                    }
                }); 
            }
        });
        
        $('#editClient').on('click', function(e) {
            e.preventDefault();
            var myform = document.getElementById('frmEditClient');
            var form = new FormData(myform);
            form.append('_token',CSRF_TOKEN);

            $.ajax({
                url:"{{ route('clients.edit') }}",
                method:'post',
                data:form,
                contentType: false,
                processData: false,
                dataType: 'json',
                success:function(res){
                    if(res.status=="success"){
                        Swal.fire({
                            title: "Actualizado",
                            text: res.message,
                            icon: "success"
                        });
                    }
                    if(res.status=="error"){
                        Swal.fire({
                        title: "Oops",
                        text: res.message,
                        icon: "warning"
                        });
                    }    
                },error:function(err){
                    alert(err);
                }
            }); 
        }); 

        $('#dtMovies').on('click', '.removeMovie', function (e) {
            e.preventDefault();
            let movieId = $(this).data('id');
            let clientId = $("#clientId").val();
            Swal.fire({
                title: "Atención",
                text: "Deseas quitar la película ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('clients.removemovie') }}",
                        method:'post',
                        data:{"_token": CSRF_TOKEN, movieId:movieId, clientId:clientId},
                        success:function(res){
                            if(res.status=="success"){
                                $('#dtMovies').DataTable().destroy();
                                fetch();
                            }
                        },error:function(err){
                            alert(err);
                        }
                    });         
                }
            });
        });
    }); 
</script>    
@stop