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
@vite('resources/js/app.js')
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
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label>Fuente:</label>
                            <select class="form-control" name="videoSource" id="videoSource">
                                <option value="NN" @selected(""==$movie->ytUrlId)>Ninguno</option>
                                <option value="YT" @selected(""!=$movie->ytUrlId)>Youtube</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
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
                    <div class="col-sm-3">
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
                    <div class="col-sm-3">
                        <div class="form-group">
                            <x-adminlte-select2 name="countryId" label="País" data-placeholder="Seleccione">
                                <option value=""></option>
                                @foreach($countries as $country)
                                    @if ($country->id==$movie->countryId)
                                        <option selected value="{{$country->id}}">{{$country->name}}</option>
                                    @else
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                    @endif
                                @endforeach
                            </x-adminlte-select2>
                        </div>
                    </div>
                </div>
                <div class="row g-3 align-items-center pb-2"  id="YTVerifyDiv" style="display: none;">
                    <div class="col-auto">
                        <label for="inputPassword6" class="col-form-label">URLId:</label>
                    </div>
                    <div class="col-auto">
                        <input type="text" class="form-control" value="{{$movie->ytUrlId}}" id="YTUrlId" name="YTUrlId" placeholder="Youtube Id">
                    </div>
                    <div class="col-auto">
                        <button type="button" class="btn btn-info" id="YTVerify">Verificar</button>
                    </div>
                    <div class="col-auto">
                        <div class="spinner-border text-primary" role="status" id="YTVerifySpinner" >
                            <span class="visually-hidden"></span>
                        </div>
                        <label class="col-form-label text-danger" id="idAlredyExists" style="display: none"><i class="fa fa-exclamation-triangle"></i> El video ya existe en nuestra base de datos</label>
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
                        <label for="directorId">Director</label>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <x-adminlte-select2 name="directorId" id="directorId" data-placeholder="Seleccione" class="flex-grow-1">
                                        <option value=""></option>
                                        @foreach($directors as $director)
                                            @if ($director->id==$movie->directorId)
                                                <option selected value="{{$director->id}}">
                                                    {{ $director->firstName.' '.$director->lastName }}
                                                </option>
                                            @else
                                                <option value="{{ $director->id }}">
                                                    {{ $director->firstName.' '.$director->lastName }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </x-adminlte-select2>
                                </div>
                            </div>
                            <div class="col-sm-6" style="padding: 0 0 0 0;!important;">
                                <button type="button"
                                        class="btn btn-outline-primary custom-button"
                                        id="btnAddDirector"
                                        title="Agregar Nuevo Director"
                                        >
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Tipo de pago:</label>
                                    <select class="form-control" name="payment_type" id="payment_type">
                                        <option value="">Ninguno</option>
                                        {{-- <option value="PT" @selected("PT"==$movie->payment_type)>Pago Total</option> --}}
                                        <option value="DO" @selected("DO"==$movie->payment_type)>Donación Obligatoria</option>
                                        {{-- <option value="DV" @selected("DV"==$movie->payment_type)>Donación Voluntaria</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 align-self-center" style="display: none" id="priceSolDiv">
                                <div class="form-group">
                                    <label for="price">Precio (S/)</label>
                                    <input type="text" class="form-control" id="price" name="price" value="{{$movie->price}}" placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-sm-4 align-self-center" style="display: none" id="priceUSDDiv">
                                <div class="form-group">
                                    <label for="price">Precio (USD)</label>
                                    <input type="text" class="form-control" id="priceUSD" name="priceUSD" value="{{$movie->priceUSD}}" placeholder="0.00">
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
                            <input type="text" class="form-control" id="trailer" value="{{$movie->trailer}}" name="trailer" placeholder="Trailer">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="urlId">Movie ID (Muse.ai)</label>
                            <input type="text" class="form-control" id="urlId" name="urlId" value="{{$movie->urlId}}" >
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 20px;">
                    <h5>Imágenes</h5>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group text-center p-4">
                            @php
                                $image1 = App\Http\Controllers\MovieController::getImage($movie->image1);
                            @endphp
                            <img src="{{ $image1 }}" class="img-fluid border img-thumbnail" id="ytImage1" />
                            <input type="hidden" id="ytImage1Src" name="ytImage1Src" value="{{ $image1 }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group text-center p-4">
                            @php
                                $image2 = App\Http\Controllers\MovieController::getImage($movie->image2);
                            @endphp
                            <img src="{{ $image2 }}" class="img-fluid border img-thumbnail" id="ytImage2" />
                            <input type="hidden" id="ytImage2Src" name="ytImage2Src" value="{{ substr($image2, 1) }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Thumbnail(780 x 439)</label>
                            <input class="form-control" name="image1" type="file" id="image1">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="name">Background(1280 x 720)</label>
                            <input class="form-control" name="image2" type="file" id="image2">
                        </div>
                    </div>
                </div>
                <div class="row" style="padding-top: 10px; background-color:#7fffd4" id="posterDiv">
                    <h5>Poster</h5>
                </div>
                <div class="row" style="background-color:#7fffd4" id="posterDivDetail1">
                    <div class="col-sm-6">
                        <div class="form-group text-center">
                            @php
                                $poster1 = App\Http\Controllers\MovieController::getImage($movie->poster1);
                            @endphp
                            <img src="{{ $poster1 }}" style="width: 100px;" class="img-fluid border" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group text-center">
                            @php
                                $poster2 = App\Http\Controllers\MovieController::getImage($movie->poster2);
                            @endphp
                            <img src="{{ $poster2 }}" style="width: 100px;" class="img-fluid border" />
                        </div>
                    </div>
                </div>
                <div class="row" style="background-color:#7fffd4" id="posterDivDetail2">
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
                <div class="row" style="padding-top: 30px;" id="captionDiv">
                    <h5>SubTitulos</h5>
                </div>
                <div class="row" id="captionDivDetail1">
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
                <div class="row" id="captionDivDetail2">
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
@include('movies.adddirector-modal')
@stop

@section('css')
    <link href="/vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">
    <link rel="stylesheet" href="/vendor/admin/main.css">
    <style>
        .swal2-html-container {
            text-align: left!important;
        }
        .custom-button {
            width: 50px; /* Set a specific width */
            height: 36px; /* Set a specific height */
            font-size: 18px; /* Adjust font size */
        }
    </style>
@stop

@section('js')
    <script src="/vendor/datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script src="/vendor/admin/main.js"></script>
    <script src="/vendor/admin/movie_edit.js"></script>
    <script>
        const YT_API_KEY = '{{ env('YT_API_KEY') }}'
        const paymentType = "{{ $movie->payment_type }}";

        if(paymentType!=""){
            $("#priceSolDiv").show();
            $("#priceUSDDiv").show();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#btnAddDirector").on('click', function() {
            $('#addModal').modal('show');
            $("#dName").val("");
            $("#dLastName").val("");
            $("#dCountryId").val("").change();
        });

        $("#addDirector").on('click', function(e) {
            e.preventDefault();

            let elements = [
                ['dName', 'Ingrese el nombre del director'],
                ['dLastName', 'Ingrese el apellido del director'],
                ['dCountryId', 'Seleccione un país']
            ];

            if(emptyfy(elements)){
                let dname = $("#dName").val();
                let dlastname = $("#dLastName").val();
                let dcountryId = $("#dCountryId").val();
                let _url = "{{ route('director.add') }}";
                let _data = {
                    dname: dname,
                    dlastname: dlastname,
                    dcountryId: dcountryId
                };
                $.ajax({
                    url:_url,
                    method:'post',
                    data:_data,
                    success:function(res){
                        if(res.status=="alert"){
                            Swal.fire({
                            title: "Oops",
                            text: res.message,
                            icon: "warning"
                            });
                        }
                        if(res.status=="success"){
                            $('#addModal').modal('hide');
                            $("#dName").val("");
                            $("#dLastName").val("");
                            $("#dCountryId").val("");

                            $("#directorId").empty();
                            var data = res.listDirectors;
                            $.each(data, function(key, val) {
                                var _name = val.firstName + " " + val.lastName;
                                var option = new Option(_name, val.id, false, false);
                                $('#directorId').append(option);
                            });
                            var _id = res.director.id;
                            $("#directorId").val(_id).trigger("change");
                        }
                    },error:function(err){
                        console.log(err);
                    }
                });
            }
        });

        $("#YTVerify").on("click", function(e) {
            e.preventDefault();
            let YTUrlId = $("#YTUrlId").val();
            if(YTUrlId==""){
                Swal.fire({
                    title: "Oops",
                    text: "Ingresar la código de Youtube",
                    icon: "warning"
                });
                $("#YTUrlId").focus();
                return;
            }
            $("#idAlredyExists").hide();
            $("#YTVerifySpinner").show();


            let _url = "{{ route('movies.verifyIdyt') }}";
            let _data = {YTUrlId:YTUrlId, movieId:"{{$movie->id}}"};
            $.ajax({
                url:_url,
                method:'post',
                data:_data,
                success:function(res){
                    $("#YTVerifySpinner").hide();
                    if(res.status=="alert"){
                        $("#idAlredyExists").show();
                    }
                    if(res.status=="success"){
                        (async () => {
                            const data = await fetchYouTubeVideoDetails(YTUrlId);
                            const duration = data.items[0].contentDetails.duration;
                            const parts = duration.match(/\d+/g);
                            let minutes = 0;
                            if(parts.length==2){
                                minutes = parseInt(parts[0]);
                            }
                            if(parts.length==3){
                                minutes = parseInt(parts[0] * 60) + parseInt(parts[1]);
                            }
                            const publishedAt = data.items[0].snippet.publishedAt;
                            const releaseDate = getFormattedDate(new Date(publishedAt));

                            const yt = data.items[0].snippet;
                            $("#name").val(yt.title);
                            $("#description").val(yt.description);
                            $("#slug").val(slugify(yt.title));
                            $("#movieLength").val(minutes);
                            $("#releaseYear").val(releaseDate);
                            $("#ytImage1").attr("src", yt.thumbnails.standard.url);
                            $("#ytImage1Src").val(yt.thumbnails.standard.url);
                            $("#ytImage2").attr("src", yt.thumbnails.maxres.url);
                            $("#ytImage2Src").val(yt.thumbnails.maxres.url);

                            $("#YTVerifySpinner").hide();
                        })()
                    }
                },error:function(err){
                    console.log(err);
                }
            });
        });
    </script>
@stop
