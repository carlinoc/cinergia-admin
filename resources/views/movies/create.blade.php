@extends('adminlte::page')

@section('title', 'Nueva Película')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>Nueva Película</h1>
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
          <form id="frmNewMovie" action="{{route('movies.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="test-l-1" role="tabpanel" class="bs-stepper-pane active dstepper-block" aria-labelledby="stepper1trigger1">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                           <x-adminlte-select2 name="categoryId" label="Categoría" data-placeholder="Seleccione">
                                <option value=""></option>
                                @foreach($categories as $language)
                                    <option value="{{$language->id}}">{{$language->name}}</option>
                                @endforeach
                           </x-adminlte-select2>
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                           <x-adminlte-select2 name="languageId" label="Idioma" data-placeholder="Seleccione">
                                <option value=""></option>
                                @foreach($languages as $language)
                                    <option value="{{$language->id}}">{{$language->name}}</option>
                                @endforeach
                           </x-adminlte-select2>
                        </div>            
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la película">
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="slug" disabled name="slug">
                        </div>            
                    </div>    
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripcion</label>
                    <textarea class="form-control" rows="3" id="description" name="description" placeholder="Breve descripcion"></textarea>
                </div>
                <div class="form-group">
                    <label class="col-form-label" for="whySee"><i class="fas fa-check"></i> Por que verla ?</label>
                    <textarea class="form-control" rows="3" id="whySee" name="whySee" placeholder="Por que ver esta película"></textarea>
                </div>
                <button class="btn btn-primary" type="button" id="next1">Siguiente</button>
            </div>
            <div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Duración (minutos)</label>
                            <input type="text" class="form-control" id="movieLength" name="movieLength" value="0" placeholder="0">
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Fecha de lanzamiento</label>
                            <input type="text" class="form-control" id="releaseYear" name="releaseYear" placeholder="Fecha de lanzamiento">
                        </div>            
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <x-adminlte-select2 name="ageRateId" label="Clasificación de la película" data-placeholder="Seleccione">
                                <option value=""></option>
                                @foreach($agerates as $agerate)
                                    <option value="{{$agerate->id}}">{{$agerate->name}}</option>
                                @endforeach
                           </x-adminlte-select2>
                        </div>        
                    </div>                
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Generos</label>
                            <select class="select2-multiple" name="genres[]" id="genres" multiple="multiple">
                                @foreach($genres as $genre)
                                    <option value="{{$genre->id}}" data-select2-id="{{$genre->id}}">{{$genre->name}}</option>
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
                                    <option value="{{$director->id}}">{{$director->firstName.' '.$director->lastName}}</option>
                                @endforeach
                           </x-adminlte-select2>
                        </div>                
                    </div>    
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tipo de pago:</label>
                                    <select class="form-control" name="payment_type" id="payment_type">
                                        <option value="">Ninguno</option>
                                        <option value="PT">Pago Total</option>
                                        <option value="DO">Donación Obligatoria</option>
                                        <option value="DV">Donación Voluntaria</option>
                                    </select>
                                </div>    
                            </div>
                            <div class="col-sm-6 align-self-center">
                                <div class="form-group">
                                    <label for="price">Precio (S/)</label>
                                    <input type="text" class="form-control" id="price" name="price" value="0.00" placeholder="0.00">
                                </div>            
                            </div>                    
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
                            <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Trailer">
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="urlId">Movie ID (Muse.ai)</label>
                            <input type="text" class="form-control" id="urlId" name="urlId">
                        </div>            
                    </div>
                </div>
                <div class="row" style="padding-top: 20px;">
                    <h5>Imágenes</h5>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">780 x 439</label>
                            <input class="form-control" name="image1" type="file" id="image1">
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">1280 x 720</label>
                            <input class="form-control" name="image2" type="file" id="image2">
                        </div>            
                    </div>
                </div>
                <div class="row" style="padding-top: 10px; background-color:#7fffd4">
                    <h5>Poster</h5>
                </div>
                <div class="row" style="background-color:#7fffd4">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">342 x 513</label>
                            <input class="form-control" name="poster1" type="file" id="poster1">
                        </div>            
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">500 x 750</label>
                            <input class="form-control" name="poster2" type="file" id="poster2">
                        </div>            
                    </div>
                </div>
                <div class="row" style="padding-top: 30px;">
                    <h5>SubTitulos</h5>
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
            var stepperFormEl = document.querySelector('#stepper1')

            stepperFormEl.addEventListener('show.bs-stepper', function (event) {
                var nextStep = event.detail.indexStep;
                var currentStep = nextStep;

                if (currentStep > 0) {
                    currentStep--;
                }
                console.log(nextStep);
            })

        });

        $("#name").keyup(function() {
            let _text = $(this).val();
            $("#slug").val(slugify(_text));      
        });       

        $("#payment_type").on("change", function() {
            let paymentType = $("#payment_type").val();
            if(paymentType==""){
                $("#price").val("0.00");        
            }
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

            let paymentType = $("#payment_type").val();
            if(paymentType!=""){
                let price = parseFloat($("#price").val()); 
                if(price==0){
                    console.log(price);
                    Swal.fire({
                        title: "Oops",
                        text: "Ingresar la cantidad del precio",
                        icon: "warning"
                    });
                    return;
                }
            }
            
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
                ['urlId', 'Ingrese la URL'],
                ['image1', 'Seleccione al menos una imagen']
            ];
            
            if(emptyfy(elements)) {
                let _form = document.getElementById('frmNewMovie');
                _form.submit();
            }
        });

    </script>
@stop