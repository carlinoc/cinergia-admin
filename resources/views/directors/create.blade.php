@extends('adminlte::page')

@section('title', 'Nuevo Director')

@section('content_header')
    <div class="row">
        <div class="col-md-auto">
            <h1>Nuevo Director</h1>
        </div>
        <div class="col">
            <a href="{{route('directors.index')}}" class="btn btn-outline-dark" role="button">Atras</a>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <form action="{{route('directors.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="slogan">Nombre</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Nombre" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="slogan">Apellido</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Apellido" required>
                        </div>
                        <div class="form-group">
                            <x-adminlte-select2 name="countryId" label="Pais" data-placeholder="Seleccione" required>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-info">
                                        <i class="fas fa-location-arrow"></i>
                                    </div>
                                </x-slot>
                                <option value=""></option>
                                @foreach($countries as $country)
                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                @endforeach
                            </x-adminlte-select2>
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