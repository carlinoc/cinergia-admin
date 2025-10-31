<!-- Modal -->
<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="frmAddPackage">    
    @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addModalLabel">Nuevo Paquete</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <label for="slogan">Slogan</label>
                        <input type="text" class="form-control" id="slogan" name="slogan" placeholder="Slogan del paquete">
                    </div>
                    <div class="input-group mt-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-code"></i></span>
                        </div>
                        <input type="text" class="form-control" id="slug" disabled name="slug">
                    </div>
                    <div class="for-group mt-2">
                        <label class="col-form-label" for="description"><i class="fas fa-check"></i> Descripcion</label>
                        <textarea class="form-control" rows="3" id="description" name="description" placeholder="Breve descripcion"></textarea>
                    </div>
                    <div class="form-group mt-2">
                        <label for="name">Background</label>
                        <input class="form-control" name="background" type="file" id="background">
                    </div>            
                </div>
                <div class="modal-footer">
                    <button id="addPackage" type="button" class="btn btn-primary">Agregar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </form>    
</div>