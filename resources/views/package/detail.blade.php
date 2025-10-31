@extends('adminlte::page')

@section('title', 'Editar Paquete')

@section('content_header')
<div class="row">
    <div class="col-md-auto">
        <h1>Editar Paquete </h1>    
    </div>
    <div class="col">
        <a href="{{route('package.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
    </div>
</div>    
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <form action="" method="POST" id="frmEditPackage">
                        <input type="hidden" id="packageId" name="packageId" value="{{$package->id}}">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="slogan">Slogan</label>
                                <input type="text" class="form-control" id="slogan" name="slogan" value="{{$package->slogan}}" placeholder="Slogan">
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-code"></i></span>
                                </div>
                                <input type="text" class="form-control" id="slug" disabled value="{{$package->slug}}" name="slug">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label" for="description">Descripcion</label>
                                <textarea class="form-control" rows="3" id="description" name="description" placeholder="Breve descripcion">{{$package->description}}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label" for="description">Background (1280 x 720)</label>
                                        <img id="packageBackground" src="/{{$package->background}}" class="img-fluid" />
                                    </div>        
                                </div>
                                <div class="col-sm-6 align-self-center">
                                    <input class="form-control" name="background" type="file" id="background">    
                                </div>                    
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    @if($package->state == 0)         
                                    <input type="checkbox" class="custom-control-input" id="state" name="state">
                                    @else
                                    <input type="checkbox" class="custom-control-input" id="state" name="state" checked>
                                    @endif
                                    <label class="custom-control-label" for="state">Publicar Paquete</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <button type="button" id="editPackage" class="btn btn-primary">Guardar Cambios</button>
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
                                <input type="hidden" id="packageId" name="packageId" value="{{$package->id}}">
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
            let packageId = $("#packageId").val();
            $.ajax({
                url: "{{ route('package.movielist') }}",
                type: "Get",
                data: {packageId:packageId},
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
                    url:"{{ route('package.addmovie') }}",
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
        
        $('#editPackage').on('click', function(e) {
            e.preventDefault();
            let slogan = $('#slogan').val();
            if(slogan!=""){
                var myform = document.getElementById('frmEditPackage');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                $.ajax({
                    url:"{{ route('package.edit') }}",
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
                            $("#packageBackground").attr("src", "/" + res.background);
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
            let packageId = $("#packageId").val();
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
                        url:"{{ route('package.removemovie') }}",
                        method:'post',
                        data:{"_token": CSRF_TOKEN, movieId:movieId, packageId:packageId},
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
        
        $("#slogan").keyup(function() {
            var slug = slugify($(this).val());
            $("#slug").val(slug);        
        });
    }); 
</script>    
@stop