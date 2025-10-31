@extends('adminlte::page')

@section('title', 'Editar Género')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>Editar Género</h1>
        </div>
        <div class="col">
            <a href="{{route('genres.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <form action="{{route('genres.update', $genre)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="slogan">Categoría</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{$genre->name}}" placeholder="Nombre del genero" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" value="{{$genre->slug}}" disabled name="slug">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripción</label>
                            <textarea class="form-control" rows="3" id="description" name="description" required placeholder="Breve descripción">{{$genre->description}}</textarea>
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
<style>
label:not(.form-check-label):not(.custom-file-label) {
  font-weight: 500;
}
</style>    
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