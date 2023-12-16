@extends('adminlte::page')

@section('title', 'Nueva categoría')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>Nueva Categoría</h1>
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
                <form action="{{route('categories.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="slogan">Categoría</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de categoría" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" disabled name="slug">
                        </div>
                    </div>    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Guardar</button>
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