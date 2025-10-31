<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddMovie">    
    @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Agregar Película</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <x-adminlte-select2 name="movieId" label="Película" data-placeholder="Seleccione">
                            <option value=""></option>
                            @foreach($movies as $movie)
                                <option data-image1="{{$movie->image1}}" data-image2="{{$movie->image2}}" value="{{$movie->id}}">{{$movie->name}}</option>
                            @endforeach
                       </x-adminlte-select2>
                    </div>
                    <div class="for-group">
                        <label id="movieName"></label>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <div style="padding:7px"><img id="movieImage1" src="/images/movie-default.jpg" class="img-fluid" /></div>
                            </div>        
                        </div>                
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div style="padding:7px"><img id="movieImage2" src="/images/movie-default.jpg" class="img-fluid" /></div>
                            </div>        
                        </div>
                    </div>
                    <div class="for-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1">
                            <label class="custom-control-label" style="font-weight: 500!important;" for="customSwitch1">Es gratis</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addMovie" type="button" class="btn btn-primary add_product">Agregar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>