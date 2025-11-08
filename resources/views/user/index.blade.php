@extends('adminlte::page')

@section('title', 'Mantenimiento de Usuarios')

@section('content_header')
    <h1>Mantenimiento de Usuarios</h1>
@stop
@vite('resources/js/app.js')
@section('content')
    <div>
        <div class="row">
            <div class="form-group col-md-6">
                <a href="#" id="newUser" class="btn btn-primary">Nuevo Usuario</a>
            </div>
        </div>
    </div>

    <div>
        <x-adminlte-card>
            <div class="card-body">
                <table id="dtUser" class="row-border" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </x-adminlte-card>
    </div>

    @include('user.create')
@stop

@section('css')
<link rel="stylesheet" href="/vendor/admin/main.css">
@stop

@section('js')
<script src="/vendor/admin/main.js"></script>
<script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    let _userId = $("#userId");
    let _name = $("#name");
    let _email = $("#email");
    let _password = $("#password");
    let _roleId = $("#roleId");

    let _dtUser = $("#dtUser");
    let _modal = $("#addModal");
    let _modalLabel = $("#addModalLabel");
    let _ds=null;

    $(document).ready(function() {

        fetchUsers();

        $('#newUser').on('click', function(e) {
            e.preventDefault();
            clearForm();
            _modalLabel.text("Nuevo Usuario");
            _modal.modal('show');

            setTimeout(function(){
                _name.focus();
            }, 300);
        });

        _dtUser.on('click', '.editUser', function (e) {
            e.preventDefault();
            let index = $(this).data('index');
            let rw = _ds[index];
            with (rw) {
                _userId.val(id);
                _name.val(name);
                _email.val(email);
                _password.val('');
                _roleId.val(role).change();
            }

            _modalLabel.text("Editar Usuario");
            _modal.modal('show');
        });

        _dtUser.on('click', '.removeUser', function (e) {
            e.preventDefault();
            let userId = $(this).data('id');
            Swal.fire({
                title: "Atención",
                text: "Deseas eliminar el usuario?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Aceptar"
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url:"{{ route('user.remove') }}",
                        method:'post',
                        data:{
                            "_token": CSRF_TOKEN,
                            userId:userId
                        },
                        success:function(res){
                            if(res.status=="success"){
                                showSuccessMsg(res.message);
                                _dtUser.DataTable().destroy();
                                fetchUsers();
                            }
                            if(res.status=="error"){
                                showErrorMsg(res.message);
                            }
                        },error:function(err){
                            console.log(err);
                        }
                    });
                }
            });
        });
    });

    $('#addUser').on('click', function(e) {
        e.preventDefault();
        let elements = [
            ['name', 'Ingrese el nombre'],
            ['email', 'Ingrese el email'],
            ['password', 'Ingrese la contraseña']
        ];

        if(emptyfy(elements)) {
            let userId = _userId.val();
            var myform = document.getElementById('frmAddUser');
            var form = new FormData(myform);
            form.append('_token',CSRF_TOKEN);

            let route = "{{ route('user.add') }}";
            if(userId!="") {
                route = "{{ route('user.edit') }}";
            }

            $.ajax({
                url:route,
                method:'post',
                data:form,
                contentType: false,
                processData: false,
                dataType: 'json',
                success:function(res){
                    if(res.status=="success"){
                        _modal.modal('hide');
                        showSuccessMsg(res.message);
                        _dtUser.DataTable().destroy();
                        clearForm();
                        fetchUsers();
                    }
                    if(res.status=="error"){
                        showErrorMsg(res.message);
                    }
                },error:function(err){
                    console.log(err);
                }
            });
        }
    });

    function clearForm() {
        _userId.val("");
        _name.val("");
        _email.val("");
        _password.val("");
        _roleId.val("1").change();
    }

    async function fetchUsers(){
        try{
            const response = await fetch("/user/list", {method: 'GET'});
            if(!response.ok){
                throw new Error("Error fetch users")
            }
            const data = await response.json();
            _ds = data.users;
            _dtUser.DataTable().destroy();
            _dtUser.DataTable({
                "data": data.users,
                "responsive": true,
                order: [[0, 'desc']],
                "columns": [
                    {
                        "render": function(data, type, row, meta) {
                            return row.id;
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.name;
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return row.email;
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            if(row.role=="1"){
                                return "Admin"
                            }else{
                                return "Operador"
                            }
                        }
                    },
                    {
                        "render": function(data, type, row, meta) {
                            return '<a href="#" data-index="'+meta.row+'" class="btn btn-sm btn-info editUser"><i class="far fa-edit"></i></a> <a href="#" data-id="'+row.id+'" class="btn btn-sm btn-danger removeUser"><i class="far fa-trash-alt"></i></a>';
                        }
                    }
                ]
            });
        }catch(error){
            console.log(error);
        }
    }
</script>
@stop
