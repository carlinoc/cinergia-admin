@extends('adminlte::page')

@section('title', 'Editar Película')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>Editar Película</h1>
        </div>
        <div class="col">
            <a href="{{route('movies.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
        </div>
    </div>
@stop

@section('content')
<div class="container flex-grow-1 flex-shrink-0 py-1">
    <div class="mb-5 p-4 bg-white shadow-sm">
      <div id="stepper1" class="bs-stepper linear">
        <div class="bs-stepper-header" role="tablist">
          <div class="step active" data-target="#test-l-1">
            <button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="test-l-1" aria-selected="true">
                <span class="bs-stepper-circle">1</span>
                <span class="bs-stepper-label">Información</span>
            </button>
          </div>
          <div class="bs-stepper-line"></div>
          <div class="step" data-target="#test-l-2">
            <button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="test-l-2" aria-selected="false" disabled="disabled">
              <span class="bs-stepper-circle">2</span>
              <span class="bs-stepper-label">Datos Adicionales</span>
            </button>
          </div>
          <div class="bs-stepper-line"></div>
          <div class="step" data-target="#test-l-3">
            <button type="button" class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="test-l-3" aria-selected="false" disabled="disabled">
              <span class="bs-stepper-circle">3</span>
              <span class="bs-stepper-label">Multimedia</span>
            </button>
          </div>
        </div>
        <div class="bs-stepper-content">
          <form id="frmEditMovie" action="{{route('movies.update', $movie)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div id="test-l-1" role="tabpanel" class="bs-stepper-pane active dstepper-block" aria-labelledby="stepper1trigger1">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                           <x-adminlte-select2 name="categoryId" label="Categoría" data-placeholder="Seleccione">
                                <option value=""></option>
                                @foreach($categories as $category)
                                    @if ($category->id==$movie->categoryId)
                                        <option selected value="{{$category->id}}">{{$category->name}}</option>
                                    @else
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endif
                                @endforeach
                           </x-adminlte-select2>
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                           <x-adminlte-select2 name="languageId" label="Idioma" data-placeholder="Seleccione">
                                <option value=""></option>
                                @foreach($languages as $language)
                                    @if ($language->id==$movie->languageId)
                                        <option selected value="{{$language->id}}">{{$language->name}}</option>
                                    @else
                                        <option value="{{$language->id}}">{{$language->name}}</option>
                                    @endif
                                @endforeach
                           </x-adminlte-select2>
                        </div>            
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" value="{{$movie->name}}" id="name" name="name" placeholder="Nombre de la película">
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" value="{{$movie->slug}}" id="slug" disabled name="slug">
                        </div>            
                    </div>    
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripcion</label>
                    <textarea class="form-control" rows="3" id="description" name="description" placeholder="Breve descripcion">{{$movie->description}}</textarea>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="whySee"><i class="fas fa-check"></i> Por que verla ?</label>
                    <textarea class="form-control" rows="3" id="whySee" name="whySee" placeholder="Por que ver esta película">{{$movie->whySee}}</textarea>
                </div>
                <button class="btn btn-primary" type="button" id="next1">Siguiente</button>
            </div>
            <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Duración (minutos)</label>
                            <input type="text" class="form-control" id="movieLength" name="movieLength" value="{{$movie->movieLength}}" placeholder="0">
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Fecha de lanzamiento</label>
                            <input type="text" class="form-control" id="releaseYear" name="releaseYear" value="{{date('d-M-y', strtotime($movie->releaseYear))}}" placeholder="Fecha de lanzamiento">
                        </div>            
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-adminlte-select2 name="ageRateId" label="Clasificación de la película" data-placeholder="Seleccione">
                                <option value=""></option>
                                @foreach($agerates as $agerate)
                                    @if ($agerate->id==$movie->ageRateId)
                                        <option selected value="{{$agerate->id}}">{{$agerate->name}}</option>
                                    @else
                                        <option value="{{$agerate->id}}">{{$agerate->name}}</option>
                                    @endif
                                @endforeach
                           </x-adminlte-select2>
                        </div>        
                    </div>                
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Generos</label>
                            <select class="select2-multiple" name="genres[]" id="genres" multiple="multiple">
                                @foreach($genres as $genre)
                                    @php
                                        $selected = App\Http\Controllers\MovieController::getGenreSelected($genre->id, $mgenres);
                                    @endphp
                                    <option {{ $selected }} value="{{$genre->id}}" data-select2-id="{{$genre->id}}">{{$genre->name}}</option>
                                @endforeach    
                            </select>
                        </div>        
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-adminlte-select2 name="directorId" label="Director" data-placeholder="Seleccione">
                                <option value=""></option>
                                @foreach($directors as $director)
                                    @if ($director->id==$movie->directorId)
                                        <option selected value="{{$director->id}}">{{$director->firstName.' '.$director->lastName}}</option>
                                    @else
                                        <option value="{{$director->id}}">{{$director->firstName.' '.$director->lastName}}</option>
                                    @endif
                                @endforeach
                           </x-adminlte-select2>
                        </div>                
                    </div>    
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="price">Precio (S/)</label>
                            <input type="text" class="form-control" id="price" name="price" value="{{$movie->price}}" placeholder="0.00">
                         </div>    
                    </div>        
                </div>
                
                <button class="btn btn-primary" type="button" onclick="stepper1.previous()">Anterior</button>
                <button class="btn btn-primary" type="button" id="next2">Siguiente</button>
            </div>
            <div id="test-l-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger3">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="trailer">Trailer</label>
                            <input type="text" class="form-control" id="trailer" value="{{$movie->trailer}}" name="trailer" placeholder="Trailer">
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="urlId">Url</label>
                            <input type="text" class="form-control" id="urlId" name="urlId" value="{{$movie->urlId}}" >
                        </div>            
                    </div>
                </div>
                <div class="row" style="padding-top: 30px;">
                    <h5>Imágenes</h5>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            @php
                                $image1 = App\Http\Controllers\MovieController::getImage($movie->image1);
                            @endphp
                            <img id="packageBackground" src="/{{ $image1 }}" class="img-fluid" />
                        </div>            
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            @php
                                $image2 = App\Http\Controllers\MovieController::getImage($movie->image2);
                            @endphp
                            <img id="packageBackground" src="/{{ $image2 }}" class="img-fluid" />
                        </div>            
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            @php
                                $image3 = App\Http\Controllers\MovieController::getImage($movie->image3);
                            @endphp
                            <img id="packageBackground" src="/{{ $image3 }}" class="img-fluid" />
                        </div>        
                    </div>                
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name">250x300</label>
                            <input class="form-control" name="image1" type="file" id="image1">
                        </div>            
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name">450x680</label>
                            <input class="form-control" name="image2" type="file" id="image2">
                        </div>            
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name">1080x920</label>
                            <input class="form-control" name="image3" type="file" id="image3">
                        </div>        
                    </div>                
                </div>
                <div class="row" style="padding-top: 30px;">
                    <h5>SubTitulos</h5>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            @php
                                $captionES = App\Http\Controllers\MovieController::getCaption($captions, 0);
                            @endphp
                            <a href="/{{ $captionES }}">/{{ $captionES }}</a>
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            @php
                                $captionEN = App\Http\Controllers\MovieController::getCaption($captions, 1);
                            @endphp
                            <a href="/{{ $captionEN }}">/{{ $captionEN }}</a>
                        </div>            
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Español</label>
                            <input class="form-control" name="captionES" type="file" id="captionES">
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Ingles</label>
                            <input class="form-control" name="captionEN" type="file" id="captionEN">
                        </div>            
                    </div>
                </div>
                <button class="btn btn-primary mt-5" type="button" onclick="stepper1.previous()">Anterior</button>
                <button id="btnSaveMovie" type="submit" class="btn btn-primary mt-5">Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>
@stop

@section('css')
    <link href="/vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
    <link rel="stylesheet" href="/vendor/admin/main.css">
    <style>
        .swal2-html-container {
            text-align: left!important;
        }
    </style>    
@stop

@section('js')
    <script src="/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script src="/vendor/admin/main.js"></script>
    <script>
        $(function() {
            $("#releaseYear").datepicker({
                "dateFormat": "yy-mm-dd"
            });
        });

        $(document).ready(function() {
            $('.select2-multiple').select2();
        });

        let stepper1
        document.addEventListener('DOMContentLoaded', function () {
            stepper1 = new Stepper(document.querySelector('#stepper1'))
        });

        $("#name").keyup(function() {
            let _text = $(this).val();
            $("#slug").val(slugify(_text));      
        });       

        $('#next1').on('click', function(e) {
            e.preventDefault();

            let elements = [
                ['categoryId', 'Seleccione una categoría'],
                ['languageId', 'Seleccione un idioma'],
                ['name', 'Ingrese el nombre de la película']
            ];

            if(emptyfy(elements)){
                stepper1.next();
            }
        });

        $('#next2').on('click', function(e) {
            e.preventDefault();

            let elements = [
                ['movieLength', 'Ingresa la duración de la película'],
                ['releaseYear', 'Ingrese la fecha de lanzamiento'],
                ['ageRateId', 'Seleccione la clasificación'],
                ['genres', 'Seleccione los géneros'],
                ['directorId', 'Seleccione el director'],
                ['price', 'Ingrese el precio']
            ];
            
            if(emptyfy(elements)){
                stepper1.next();
            }
        });

        $('#btnSaveMovie').on('click', function(e) {
            e.preventDefault();

            let elements = [
                ['trailer', 'Ingresa el trailer'],
                ['urlId', 'Ingrese la URL']
            ];
            
            if(emptyfy(elements)) {
                let _form = document.getElementById('frmEditMovie');
                _form.submit();
            }
        });

    </script>
@stop