<div class="modal fade" id="addModal" aria-labelledby="addModalLabel" aria-hidden="true">
    <form action="" method="POST" id="formAddLanguage">
      @csrf
      <input type="hidden" id="languageId">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="addModalLabel">Nuevo Idioma</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="for-group mt-2">
              <label for="languageName">Idioma</label>
              <input type="text" class="form-control" id="name" name="name"
                placeholder="Nombre del Idioma">
            </div>
          </div>
          <div class="modal-footer">
            <button id="addLanguage" type="button" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </form>
  </div>  