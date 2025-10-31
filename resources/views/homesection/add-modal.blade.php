<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddMovie">    
    @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nueva Seccion del Home</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <x-adminlte-select2 name="websiteId" label="Web" data-placeholder="Seleccione">
                             <option value=""></option>
                             @foreach($websites as $website)
                                 <option value="{{$website->id}}">{{$website->title}}</option>
                             @endforeach
                        </x-adminlte-select2>
                    </div>
                    <div class="for-group">
                       <x-adminlte-select2 name="sectionId" label="Tipo" data-placeholder="Seleccione">
                            <option value=""></option>
                            @foreach($sections as $section)
                                <option value="{{$section->id}}">{{$section->name}}</option>
                            @endforeach
                       </x-adminlte-select2>
                    </div>
                    <div class="for-group">
                        <label for="title">Titulo</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Titulo de la sección">
                    </div>
                    <div class="for-group">
                        <label for="title">Titulo</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Titulo de la sección">
                    </div>
                    <div class="for-group">
                        <label for="title">Titulo</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Titulo de la sección">
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addHSection" type="button" class="btn btn-primary add_product">Agregar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>