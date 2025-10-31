<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="formAddSection">
      @csrf
      <input type="hidden" id="sectionId">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="addModalLabel">Nueva Seccion</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="for-group mt-2">
              <label for="section">Sección</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la seccion">
            </div>
            <div class="input-group mt-2">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-code"></i></span>
                </div>
                <input type="text" class="form-control" id="slug" disabled name="slug">
            </div>
            <div class="for-group mt-2">
              <label for="maxMovies">Maximo de Películas</label>
              <input type="text" class="form-control" id="maxMovies" name="maxMovies" placeholder="0">
            </div>
          </div>
          <div class="modal-footer">
            <button id="addSection" type="button" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </form>
  </div>  