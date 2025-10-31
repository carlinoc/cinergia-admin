<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
  <form action="" method="POST" id="frmAddNewDirector" novalidate>
    @csrf
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content border-0 shadow-sm rounded-lg" style="background-color: #f8f9fa;">

        <!-- Header -->
        <div class="modal-header" style="background-color: #e9ecef; border-bottom: 1px solid #dee2e6;">
          <h5 class="modal-title text-secondary font-weight-bold mb-0" id="addModalLabel">
            <i class="fas fa-user-plus text-primary mr-2"></i> Agregar Nuevo Director
          </h5>
          <button type="button" class="close text-muted" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Body -->
        <div class="modal-body px-4 py-3">
          <div class="form-group mb-3">
            <label for="dName" class="font-weight-semibold text-secondary">Nombre:</label>
            <input
              type="text"
              class="form-control form-control-sm"
              id="dName"
              name="dName"
              placeholder="Ingrese el nombre del director"
              required>
          </div>

          <div class="form-group mb-3">
            <label for="dLastName" class="font-weight-semibold text-secondary">Apellidos:</label>
            <input
              type="text"
              class="form-control form-control-sm"
              id="dLastName"
              name="dLastName"
              placeholder="Ingrese el apellido del director"
              required>
          </div>

          <div class="form-group">
            <label for="dCountryId" class="font-weight-semibold text-secondary">País:</label>
            <x-adminlte-select2
              id="dCountryId"
              name="dCountryId"
              data-placeholder="Seleccione un país"
              required>
              <option value=""></option>
              @foreach($countries as $country)
                <option value="{{$country->id}}">{{$country->name}}</option>
              @endforeach
            </x-adminlte-select2>
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer bg-light border-0">
          <button id="addDirector" type="button" class="btn btn-primary btn-sm px-3">
            <i class="fas fa-check mr-1"></i> Agregar
          </button>
          <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-dismiss="modal">
            <i class="fas fa-times mr-1"></i> Cancelar
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
