@extends('adminlte::page')

@section('title', 'Cortos Gratis')

@section('content_header')
    <h1>Cortos Gratis</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Agregar Película</a>
            </div>    
        </div>
    </div>

    <div>
        <x-adminlte-card >
            <div class="card-body">
                <table id="dtFreeShorts" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('freeshort.add-modal')
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
                url: "{{ route('freeshort.list') }}",
                type: "Get",
                data: {},
                dataType: "json",
                success: function(data) {
                    $('#dtFreeShorts').DataTable({
                        "data": data.freeshorts,
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
                                "data": "image",
                                "render": function(data, type, row, meta) {
                                    return '<div style="width:150px;"><img src="/'+row.image1+'" class="img-fluid" /></div>';
                                }
                            },
                            {
                                "data": null,
                                "render": function(data, type, row, meta) {
                                    return '<a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeMovie"><i class="fas fa-trash"></i></a>';
                                },
                                "targets": -1
                            }
                        ]
                    });
                }
            });
        }
        fetch();

        $('#movieId').on('select2:select', function (e) {
            var src1 = $('#movieId :selected').attr('data-image1');
            var src2 = $('#movieId :selected').attr('data-image2');
            var name = $('#movieId :selected').text();
            $("#movieImage1").attr("src", src1);
            $("#movieImage2").attr("src", src2);
            $("#movieName").html(name);
        });    

        $('#addMovie').on('click', function(e) {
            e.preventDefault();
            let movieId = $('#movieId').val();
            if(movieId!=""){
                $.ajax({
                    url:"{{ route('freeshort.add') }}",
                    method:'post',
                    data:{movieId:movieId},
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
                            $("#movieId").val("").change();
                            $("#movieImage1").attr("src", "/images/movie-default.jpg");
                            $("#movieImage2").attr("src", "/images/movie-default.jpg");
                            $("#movieName").html("");
                            $('#dtFreeShorts').DataTable().destroy();
                            fetch();
                        }
                    },error:function(err){
                        alert(err);
                    }
                }); 
            }
        });

        $('#dtFreeShorts').on('click', '.removeMovie', function (e) {
            e.preventDefault();
            let freeShortId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas quitar la película ?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('freeshort.remove') }}",
                        method:'post',
                        data:{freeShortId:freeShortId},
                        success:function(res){
                            if(res.status=="success"){
                                $('#dtFreeShorts').DataTable().destroy();
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