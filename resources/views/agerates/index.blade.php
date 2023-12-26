@extends('adminlte::page')

@section('title', 'Clasificación de edad')

@section('content_header')
  <h1>Clasificación de edad</h1>
@stop

@section('content')
  <div>
    <div class="row">
      <div class="form-group col-md-6">
        <a href="#" id="newAgeRate" class="btn btn-primary">Crear Clasificación</a>
      </div>
    </div>
  </div>

  <div>
    <x-adminlte-card>
      <div class="card-body">
        <table id="dtAgeRates" class="row-border" style="width:100%">
          <thead>
            <tr>
              <th>Id</th>
              <th>Clasificación</th>
              <th>Opciones</th>
            </tr>
          </thead>
        </table>
      </div>
    </x-adminlte-card>
  </div>

  @include('agerates.add-modal')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){

        function fetch() {
            $.ajax({
                url: "{{ route('agerates.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    $('#dtAgeRates').DataTable({
                        "data": data.agerates,
                        "responsive": true,
                        order: [[0, 'desc']],
                        "columns": [
                            {
                                "data": "id",
                                "render": function(data, type, row, meta) {
                                    return row.id;
                                }
                            },
                            {
                                "data": "name",
                                "render": function(data, type, row, meta) {
                                    return row.name;
                                }
                            },
                            {
                                "data": null,
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" data-id="'+row.id+'" data-name="'+row.name+'" class="btn btn-sm btn-info editAgeRate">Editar</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeAgeRate"><i class="far fa-trash-alt"></i></a>';
                                },
                                "targets": -1
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newAgeRate').on('click', function(e) {
            e.preventDefault();
            $("#ageRateId").val("");
            $("#name").val("");
            $("#addModalLabel").text("Crear Clasificación de Edad");
            $('#addModal').modal('show');
        });

        $('#addAgeRate').on('click', function(e) {
            e.preventDefault();
            let name = $('#name').val();
            if(name!=""){
                let ageRateId = $('#ageRateId').val();
                let _url = "{{ route('agerates.add') }}";
                let _data = {name:name};
                if(ageRateId!=""){
                    _url = "{{ route('agerates.edit') }}";
                    _data = {name:name, ageRateId:ageRateId};
                }
                console.log(ageRateId);
                $.ajax({
                    url:_url,
                    method:'post',
                    data:_data,
                    success:function(res){
                        if(res.status=="error"){
                            Swal.fire({
                            title: "Oops",
                            text: res.message,
                            icon: "warning"
                            });
                        }    
                        if(res.status=="success"){
                            $('#addModal').modal('hide');
                            $("#name").val("");
                            $('#dtAgeRates').DataTable().destroy();
                            fetch();
                        }
                    },error:function(err){
                        alert(err);
                    }
                }); 
            }else{
                $('#name').focus();
                Swal.fire({
                    title: "Oops",
                    text: "Ingresar la clasificación de edad",
                    icon: "warning"
                });
            }
        });

        $('#dtAgeRates').on('click', '.editAgeRate', function (e) {
            e.preventDefault();
            let ageRateId = $(this).data('id');
            let name = $(this).data('name');
            $("#ageRateId").val(ageRateId);
            $("#name").val(name);
            $("#addModalLabel").text("Editar clasificación de edad");
            $('#addModal').modal('show');
        });    

        $('#dtAgeRates').on('click', '.removeAgeRate', function (e) {
            e.preventDefault();
            let ageRateId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar la clasificación de edad?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('agerates.remove') }}",
                        method:'post',
                        data:{ageRateId:ageRateId},
                        success:function(res){
                            if(res.status=="success"){
                                $('#dtAgeRates').DataTable().destroy();
                                fetch();
                            }
                        },error:function(err){
                            alert(err);
                        }
                    });         
                }
            });
        });    
    }); 
</script>    
@stop