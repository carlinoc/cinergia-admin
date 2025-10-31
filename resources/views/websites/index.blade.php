@extends('adminlte::page')

@section('title', 'Mantenimiento de WebSites')

@section('content_header')
    <h1>Mantenimiento de WebSites</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newWebSite" class="btn btn-primary">Crear Nueva Web</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card >
            <div class="card-body">
                <table id="dtWebSites" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Titulo</th>
                            <th>Slug</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('websites.add-modal')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    $(document).ready(function(){

        function fetch() {
            $.ajax({
                url: "{{ route('websites.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    $('#dtWebSites').DataTable({
                        "data": data.websites,
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
                                "data": "title",
                                "render": function(data, type, row, meta) {
                                    return row.title;
                                }
                            },
                            {
                                "data": "slug",
                                "render": function(data, type, row, meta) {
                                    return row.slug;
                                }
                            },
                            {
                                "data": null,
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" data-id="'+row.id+'" data-title="'+row.title+'" data-slug="'+row.slug+'" data-description="'+row.description+'" data-logo="'+row.logo+'" data-background="'+row.background+'" data-color1="'+row.color1+'" data-color2="'+row.color2+'" data-color3="'+row.color3+'" data-color4="'+row.color4+'" class="btn btn-sm btn-info editWebSite">Editar</a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeWebSite"><i class="far fa-trash-alt"></i></a>';
                                },
                                "targets": -1
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        function clearForm(){
            $("#websiteId").val("");
            $("#title").val("");
            $("#slug").val("");
            $("#description").val("");
            $("#logo").val("");
            $("#background").val("");
            $("#color1").val("");
            $("#color2").val("");
            $("#color3").val("");
            $("#color4").val("");
            $("#plogo").attr('src', '/images/movie-default.JPG');
            $("#pbackground").attr('src', '/images/movie-default.JPG');
        }

        $('#newWebSite').on('click', function(e) {
            e.preventDefault();
            clearForm();
            $("#addModalLabel").text("Nueva Web");
            $('#addModal').modal('show');
        });

        $('#addWebSite').on('click', function(e) {
            e.preventDefault();
            let elements = [
                ['title', 'Ingrese el titulo de la web']
            ];

            if(emptyfy(elements)){
                let websiteId = $('#websiteId').val();
                var myform = document.getElementById('frmAddWebSite');
                var form = new FormData(myform);
                form.append('_token',CSRF_TOKEN);

                let _url = "{{ route('websites.add') }}";
                if(websiteId!=""){
                    _url = "{{ route('websites.edit') }}";
                }

                $.ajax({
                    url:_url,
                    method:'post',
                    data:form,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success:function(res){
                        if(res.status=="success"){
                            $('#addModal').modal('hide');
                            clearForm();
                            $('#dtWebSites').DataTable().destroy();
                            fetch();
                        }
                        if(res.status=="error"){
                            Swal.fire({
                                title: "Atención",
                                html: res.message,
                                icon: "warning",
                                confirmButtonColor: "#3085d6",
                                confirmButtonText: "Aceptar"
                            });
                        }
                    },error:function(err){
                        alert(err);
                    }
                }); 
            }
        });

        $('#dtWebSites').on('click', '.editWebSite', function (e) {
            e.preventDefault();
            let websiteId = $(this).data('id');
            let title = $(this).data('title');
            let slug = $(this).data('slug');
            let description = $(this).data('description');
            let logo = $(this).data('logo');
            let background = $(this).data('background');
            let color1 = $(this).data('color1');
            let color2 = $(this).data('color2');
            let color3 = $(this).data('color3');
            let color4 = $(this).data('color4');

            $("#websiteId").val(websiteId);
            $("#title").val(title);
            $("#slug").val(slug);
            $("#description").val(description);
            $("#plogo").attr('src', logo);
            $("#pbackground").attr('src', background);
            $("#color1").val(color1);
            $("#color2").val(color2);
            $("#color3").val(color3);
            $("#color4").val(color4);

            $("#addModalLabel").text("Editar Web");
            $('#addModal').modal('show');
        });    

        $('#dtWebSites').on('click', '.removeWebSite', function (e) {
            e.preventDefault();
            let websiteId = $(this).data('id');
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
                        url:"{{ route('websites.remove') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            websiteId:websiteId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                $('#dtWebSites').DataTable().destroy();
                                fetch();
                            }
                        },error:function(err){
                            alert(err);
                        }
                    });         
                }
            });
        });
        
        $("#title").keyup(function() {
            var slug = slugify($(this).val());
            $("#slug").val(slug);        
        });
    }); 
</script>    
@stop