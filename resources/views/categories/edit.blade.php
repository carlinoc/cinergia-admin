@extends('adminlte::page')

@section('title', 'Editar categoría')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>Editar Categoría</h1>
        </div>
        <div class="col">
            <a href="{{route('categories.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <form action="{{route('categories.update', $category)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="slogan">Categoría</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$category->name}}" placeholder="Nombre de categoría" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" value="{{$category->slug}}" disabled name="slug">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripción</label>
                            <textarea class="form-control" rows="3" id="description" name="description" required placeholder="Breve descripción">{{$category->description}}</textarea>
                        </div>
                    </div>    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
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
    $(document).ready(function() {
        $("#name").keyup(function() {
            var slug = slugify($(this).val());
            $("#slug").val(slug);        
        });        
    });    
</script>    
@stop