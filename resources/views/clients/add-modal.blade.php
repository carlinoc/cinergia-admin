<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="formAddClient">
      @csrf
      <input type="hidden" id="clientId">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="addModalLabel">Nuevo Cliente</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="for-group mt-2">
              <label for="name">Nombre</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Nombre del cliente">
            </div>
            <div class="for-group mt-2">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <div class="form-group mt-2">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="active" name="active" checked>
                    <label class="custom-control-label" for="active">Cliente activo</label>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="addClient" type="button" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </form>
  </div>  