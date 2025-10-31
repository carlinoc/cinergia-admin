@extends('adminlte::page')

@section('title', 'Editar Sección del Home')

@section('content_header')
<div class="row">
    <div class="col-md-auto">
        <h1>Editar sección del home: {{$hsection->sectionName}}</h1>    
    </div>
    <div class="col">
        <a href="{{route('homesection.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
    </div>
</div>    
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <form action="" method="POST" id="frmEditHSection">
                        <input type="hidden" id="hsectionId" name="hsectionId" value="{{$hsection->id}}">
                        <div class="card-body">
                            <div class="for-group">
                                <x-adminlte-select2 name="websiteId" label="Web" data-placeholder="Seleccione">
                                     <option value=""></option>
                                     @foreach($websites as $website)
                                        @if ($website->id==$hsection->websiteId)
                                            <option selected value="{{$website->id}}">{{$website->title}}</option>
                                        @else
                                            <option value="{{$website->id}}">{{$website->title}}</option>
                                        @endif
                                     @endforeach
                                </x-adminlte-select2>
                            </div>
                            <div class="form-group">
                                <x-adminlte-select2 name="sectionId" label="Tipo" data-placeholder="Seleccione">
                                    <option value=""></option>
                                    @foreach($sections as $section)
                                        @if ($section->id==$hsection->sectionId)
                                            <option selected value="{{$section->id}}">{{$section->name}}</option>
                                        @else
                                            <option value="{{$section->id}}">{{$section->name}}</option>
                                        @endif
                                    @endforeach
                               </x-adminlte-select2>
                            </div>
                            <div class="row">
                                <label class="font-weight-bold"> Maximo de Peliculas: {{$hsection->maxMovies}}</label>
                            </div>
                            <div class="form-group">
                                <label for="title">Titulo</label>
                                <input type="text" class="form-control" id="title" name="title" value="{{$hsection->title}}" placeholder="Titulo de la sección">
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="background">Background (1280 x 720)</label>
                                        <img id="hsectionBackground" src="/{{$hsection->background}}" class="img-fluid" />
                                    </div>        

                                </div>
                                <div class="col-sm-6 align-self-center">
                                    <input class="form-control" name="background" type="file" id="background">    
                                </div>                    
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="button" id="editHSection" class="btn btn-primary">Guardar Cambios</button>
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
                                <input type="hidden" id="hsectionId" name="hsectionId" value="{{$hsection->id}}">
                                <x-adminlte-select2 name="movieId" data-placeholder="Seleccione">
                                    <option value=""></option>
                                    @foreach($movies as $movie)
                                        <option value="{{$movie->id}}">{{$movie->name}}</option>
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
                                            <th>Name</th>
                                            <th>slug</th>
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
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function(){

        function fetch() {
            let hsectionId = $("#hsectionId").val();
            $.ajax({
                url: "{{ route('homesection.movielist') }}",
                type: "Get",
                data: {hsectionId:hsectionId},
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
                                "data": "slug",
                                "render": function(data, type, row, meta) {
                                    return row.slug;
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
                    url:"{{ route('homesection.addmovie') }}",
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
        
        $('#editHSection').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['sectionId', 'Seleccione la sección']
            ];

            if(emptyfy(elements)){
                var myform = document.getElementById('frmEditHSection');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                $.ajax({
                    url:"{{ route('homesection.edit') }}",
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
                            $("#hsectionBackground").attr("src", "/" + res.background);
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

        $('#dtMovies').on('click', '.removeMovie', function (e) {
            e.preventDefault();
            let movieId = $(this).data('id');
            let hsectionId = $("#hsectionId").val();
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
                        url:"{{ route('homesection.removemovie') }}",
                        method:'post',
                        data:{"_token": CSRF_TOKEN, movieId:movieId, hsectionId:hsectionId},
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