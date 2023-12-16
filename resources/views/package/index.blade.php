@extends('adminlte::page')

@section('title', 'Paquetes de Películas')

@section('content_header')
    <h1>Paquetes de Películas</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Crear Paquete</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card >
            <div class="card-body">
                <table id="dtPackages" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Películas</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('package.add-modal')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    $(document).ready(function() {

        function fetch() {
            $.ajax({
                url: "{{ route('package.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    $('#dtPackages').DataTable({
                        "data": data.packages,
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
                                    return row.slogan;
                                }
                            },
                            {
                                "data": "peliculas",
                                "render": function(data, type, row, meta) {
                                    return row.movies;
                                }
                            },
                            {
                                "data": "Estado",
                                "render": function(data, type, row, meta) {
                                    return (row.state==0?'<small class="badge badge-secondary">NO Publicado</small>':'<small class="badge badge-success">Publicado</small>');
                                }
                            },
                            {
                                "data": null,
                                "render": function(data, type, row, meta) {
                                    return '<a href="/detail/'+row.id+'" class="btn btn-sm btn-info">Detalle</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removePackage"><i class="far fa-trash-alt"></i></a>';
                                },
                                "targets": -1
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#addPackage').on('click', function(e) {
            e.preventDefault();
            let slogan = $('#slogan').val();
            if(slogan!=""){
                var myform = document.getElementById('frmAddPackage');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                $.ajax({
                    url:"{{ route('package.add') }}",
                    method:'post',
                    data:form,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success:function(res){
                        if(res.status=="success"){
                            $('#addModal').modal('hide');
                            $("#movieName").html("slogan");
                            $('#background').val('');
                            $('#dtPackages').DataTable().destroy();
                            fetch();
                        }
                    },error:function(err){
                        alert(err);
                    }
                }); 
            }else{
                $('#slogan').focus();
                Swal.fire({
                    title: "Oops",
                    text: "Ingresar el nombre o slogan del paquete",
                    icon: "warning"
                });
            }
        });

        $('#dtPackages').on('click', '.removePackage', function (e) {
            e.preventDefault();
            let packageId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar el paquete y sus películas relacionadas?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('package.remove') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            packageId:packageId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                $('#dtPackages').DataTable().destroy();
                                fetch();
                            }
                        },error:function(err){
                            alert(err);
                        }
                    });         
                }
            });
        });
        
        $("#slogan").keyup(function() {
            var slug = slugify($(this).val());
            $("#slug").val(slug);        
        });
    }); 
</script>    
@stop