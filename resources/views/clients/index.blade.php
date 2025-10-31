@extends('adminlte::page')

@section('title', 'Mantenimiento de Clientes')

@section('content_header')
    <h1>Mantenimiento de Clientes</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newClient" class="btn btn-primary">Agregar Cliente</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card >
            <div class="card-body">
                <table id="dtClients" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Películas</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('clients.add-modal')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function(){

        function fetch() {
            $.ajax({
                url: "{{ route('clients.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    $('#dtClients').DataTable({
                        "data": data.clients,
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
                                "data": "email",
                                "render": function(data, type, row, meta) {
                                    return row.email;
                                }
                            },
                            {
                                "data": "movies",
                                "render": function(data, type, row, meta) {
                                    return row.movies;
                                }
                            },
                            {
                                "data": "active",
                                "render": function(data, type, row, meta) {
                                    return (row.active==0?'<small class="badge badge-secondary">Inactivo</small>':'<small class="badge badge-success">Activo</small>');
                                }
                            },
                            {
                                "data": null,
                                "render": function(data, type, row, meta) {
                                    return '<a href="/client-detail/'+ row.id +'" class="btn btn-sm btn-info editClient">Detalle</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeClient"><i class="far fa-trash-alt"></i></a>';
                                },
                                "targets": -1
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newClient').on('click', function(e) {
            e.preventDefault();
            $("#clientId").val("");
            $("#name").val("");
            $("#email").val("");
            $("#addModalLabel").text("Nuevo Cliente");
            $('#addModal').modal('show');
        });

        $('#addClient').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['name', 'Ingrese el nombre del cliente'],
                ['name', 'Ingrese el email del cliente'],
            ];

            if(emptyfy(elements)){
                let name = $('#name').val();
                let email = $('#email').val();
                let active = $('#active').val();
                let clientId = $('#clientId').val();
                let _url = "{{ route('clients.add') }}";
                let _data = {name:name, email:email, active:active};
                if(clientId!=""){
                    _url = "{{ route('clients.edit') }}";
                    _data = {name:name, email:email, active:active, clientId:clientId};
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
                            $("#email").val("");
                            $('#dtClients').DataTable().destroy();
                            fetch();
                        }
                    },error:function(err){
                        alert(err);
                    }
                }); 
            }
        });

        $('#dtClients').on('click', '.removeClient', function (e) {
            e.preventDefault();
            let clientId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar el cliente?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('clients.remove') }}",
                        method:'post',
                        data:{clientId:clientId},
                        success:function(res){
                            if(res.status=="success"){
                                $('#dtClients').DataTable().destroy();
                                fetch();
                            }
                        },error:function(err){
                            alert(err);
                        }
                    });         
                }
            });
        });
        
        $("#name").keyup(function() {
            var slug = slugify($(this).val());
            $("#slug").val(slug);        
        });
    }); 
</script>    
@stop