@extends('adminlte::page')

@section('title', 'Mantenimiento de Secciones del Home')

@section('content_header')
    <h1>Mantenimiento de Secciones del Home</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newHSection" class="btn btn-primary">Crear Sección del Home</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card >
            <div class="card-body">
                <table id="dtHomeSection" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Web</th>
                            <th>Seccion</th>
                            <th>Titulo</th>
                            <th>Peliculas</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('homesection.add-modal')
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
                url: "{{ route('homesection.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    $('#dtHomeSection').DataTable({
                        "data": data.hsections,
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
                                "data": "web",
                                "render": function(data, type, row, meta) {
                                    return row.web;
                                }
                            },
                            {
                                "data": "sectionName",
                                "render": function(data, type, row, meta) {
                                    return row.sectionName;
                                }
                            },
                            {
                                "data": "title",
                                "render": function(data, type, row, meta) {
                                    return row.title;
                                }
                            },
                            {
                                "data": "peliculas",
                                "render": function(data, type, row, meta) {
                                    return row.movies;
                                }
                            },
                            {
                                "data": null,
                                "render": function(data, type, row, meta) {
                                    return '<a href="/detailhsection/'+row.id+'" class="btn btn-sm btn-info detailHSection">Detalle</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeHSection"><i class="far fa-trash-alt"></i></a>';
                                },
                                "targets": -1
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newHSection').on('click', function(e) {
            e.preventDefault();
            $("#websiteId").val("").change();
            $("#sectionId").val("").change();
            $("#title").val("");
            $("#addModalLabel").text("Nueva Sección del Home");
            $('#addModal').modal('show');
        });

        $('#addHSection').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['websiteId', 'Seleccione la web'],
                ['sectionId', 'Seleccione la sección']
            ];

            if(emptyfy(elements)){
                let websiteId = $('#websiteId').val();
                let sectionId = $('#sectionId').val();
                let title = $('#title').val();
                let data = {title:title, sectionId:sectionId, websiteId:websiteId};
                $.ajax({
                    url:"{{ route('homesection.add') }}",
                    method:'post',
                    data:data,
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
                            $('#dtHomeSection').DataTable().destroy();
                            fetch();
                        }
                    },error:function(err){
                        alert(err);
                    }
                }); 
            }
        });

        $('#dtHomeSection').on('click', '.removeHSection', function (e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar la sección del home y todas sus peliculas relacionadas?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('homesection.remove') }}",
                        method:'post',
                        data:{id:id},
                        success:function(res){
                            if(res.status=="success"){
                                $('#dtHomeSection').DataTable().destroy();
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