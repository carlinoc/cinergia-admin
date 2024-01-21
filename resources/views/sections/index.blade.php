@extends('adminlte::page')

@section('title', 'Mantenimiento de Secciones')

@section('content_header')
    <h1>Mantenimiento de Secciones</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newSection" class="btn btn-primary">Crear Sección</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card >
            <div class="card-body">
                <table id="dtSections" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Slug</th>
                            <th>Max Peliculas</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('sections.add-modal')
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
                url: "{{ route('sections.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    $('#dtSections').DataTable({
                        "data": data.sections,
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
                                "data": "slug",
                                "render": function(data, type, row, meta) {
                                    return row.slug;
                                }
                            },
                            {
                                "data": "maxMovies",
                                "render": function(data, type, row, meta) {
                                    return row.maxMovies;
                                }
                            },
                            {
                                "data": null,
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" data-id="'+row.id+'" data-name="'+row.name+'" data-slug="'+row.slug+'" data-max="'+row.maxMovies+'" class="btn btn-sm btn-info editSection">Editar</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeSection"><i class="far fa-trash-alt"></i></a>';
                                },
                                "targets": -1
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#newSection').on('click', function(e) {
            e.preventDefault();
            $("#sectionId").val("");
            $("#name").val("");
            $("#slug").val("");
            $("#maxMovies").val("");
            $("#addModalLabel").text("Nueva Sección");
            $('#addModal').modal('show');
        });

        $('#addSection').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['name', 'Ingrese el nombre de la sección'],
                ['maxMovies', 'Ingrese el maximo de peliculas']
            ];

            if(emptyfy(elements)){
                let name = $('#name').val();
                let slug = $('#slug').val();
                let sectionId = $('#sectionId').val();
                let maxMovies = $('#maxMovies').val();
                let _url = "{{ route('sections.add') }}";
                let _data = {name:name, slug:slug, maxMovies:maxMovies};
                if(sectionId!=""){
                    _url = "{{ route('sections.edit') }}";
                    _data = {name:name, slug:slug, maxMovies:maxMovies, sectionId:sectionId};
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
                            $("#slug").val("");
                            $('#dtSections').DataTable().destroy();
                            fetch();
                        }
                    },error:function(err){
                        alert(err);
                    }
                }); 
            }
        });

        $('#dtSections').on('click', '.editSection', function (e) {
            e.preventDefault();
            let sectionId = $(this).data('id');
            let name = $(this).data('name');
            let slug = $(this).data('slug');
            let maxMovies = $(this).data('max');
            $("#sectionId").val(sectionId);
            $("#name").val(name);
            $("#slug").val(slug);
            $("#maxMovies").val(maxMovies);
            $("#addModalLabel").text("Editar Idioma");
            $('#addModal').modal('show');
        });    

        $('#dtSections').on('click', '.removeSection', function (e) {
            e.preventDefault();
            let sectionId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar la sección?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('sections.remove') }}",
                        method:'post',
                        data:{sectionId:sectionId},
                        success:function(res){
                            if(res.status=="success"){
                                $('#dtSections').DataTable().destroy();
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