@extends('adminlte::page')

@section('title', 'Mantenimiento de Idiomas')

@section('content_header')
    <h1>Mantenimiento de Idiomas</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newLanguage" class="btn btn-primary">Crear Idioma</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card >
            <div class="card-body">
                <table id="dtLanguages" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Idioma</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('languages.add-modal')
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
                url: "{{ route('languages.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    $('#dtLanguages').DataTable({
                        "data": data.languages,
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
                                    return '<a href="#" data-id="'+row.id+'" data-name="'+row.name+'" class="btn btn-sm btn-info editLanguage">Editar</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeLanguage"><i class="far fa-trash-alt"></i></a>';
                                },
                                "targets": -1
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newLanguage').on('click', function(e) {
            e.preventDefault();
            $("#languageId").val("");
            $("#name").val("");
            $("#addModalLabel").text("Nuevo Idioma");
            $('#addModal').modal('show');
        });

        $('#addLanguage').on('click', function(e) {
            e.preventDefault();
            let name = $('#name').val();
            if(name!=""){
                let languageId = $('#languageId').val();
                let _url = "{{ route('languages.add') }}";
                let _data = {name:name};
                if(languageId!=""){
                    _url = "{{ route('languages.edit') }}";
                    _data = {name:name, languageId:languageId};
                }
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
                            $('#dtLanguages').DataTable().destroy();
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
                    text: "Ingresar el nombre del idioma",
                    icon: "warning"
                });
            }
        });

        $('#dtLanguages').on('click', '.editLanguage', function (e) {
            e.preventDefault();
            let languageId = $(this).data('id');
            let name = $(this).data('name');
            $("#languageId").val(languageId);
            $("#name").val(name);
            $("#addModalLabel").text("Editar Idioma");
            $('#addModal').modal('show');
        });    

        $('#dtLanguages').on('click', '.removeLanguage', function (e) {
            e.preventDefault();
            let langaueId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar el idioma?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('languages.remove') }}",
                        method:'post',
                        data:{languageId:langaueId},
                        success:function(res){
                            if(res.status=="success"){
                                $('#dtLanguages').DataTable().destroy();
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