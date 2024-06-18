@extends('adminlte.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Empleados')
@section('content_header_title', 'Empleados')
@section('content_header_subtitle', 'Registro')

{{-- plugins --}}
{{-- Datatable --}}
@section('plugins.Datatables', true)
{{-- Sweetalert2 --}}
@section('plugins.Sweetalert2', true)

{{-- Content body: main page content --}}

@section('content_body')
    <div class="mb-3">
        <button type="button" class="btn btn-primary" data-toggle="modal" onclick="crear()">
            Agregar Empleado
        </button>
    </div>
    <div class="container mt-4">
        <table class="table table-striped table-hover display responsive nowrap" cellspacing="0" id="datatable"
            style="width: 100%">
            <thead class="bg-info">
                <tr>
                    <th data-priority="1">Foto</th>
                    <th data-priority="2">Codigo</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Departamento</th>
                    <th class="text-center">Accion</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot class="bg-info">
                <tr>
                    <th>Foto</th>
                    <th>Codigo</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Departamento</th>
                    <th class="text-center">Accion</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="empleado" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="min-width: 600px">
            <div class="modal-content">
                <form id="formulario" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" id="bg-titulo">
                        <h5 class="modal-title" id="titulo"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img id="preview" src="" width="200" height="200" alt="Imagen previsualizada">
                        </div>
                        <div class="form-group">
                            <label for="foto" id="fotoTitle">Foto Del empleado || Solo Formato (JPG Y PNG)</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept=".jpg,.png"
                                required onchange="previewImage()">
                        </div>
                        {{-- Codigo --}}
                        <div class="form-group text-center">
                            <label for="codigo">Codigo para el empleado.</label>
                            <input type="text" class="form-control" id="codigo" placeholder="Codigo del empleado."
                                required>
                            <small id="small" class="form-text text-muted">Codigo del empleado.</small>
                        </div>
                        {{-- Datos Personales --}}
                        {{-- Nombres --}}
                        <div class="row mb-3">
                            <div class="col text-center">
                                <label for="Pnombre">Primer Nombre.</label>
                                <input type="text" class="form-control" id="Pnombre"
                                    placeholder="Primer nombre del empleado." max="255" required>
                                <small id="small" class="form-text text-muted">Primer nombre del empleado.</small>
                            </div>
                            <div class="col text-center">
                                <label for="Snombre">Segundo Nombre.</label>
                                <input type="text" class="form-control" id="Snombre"
                                    placeholder="Segundo nombre del empleado. (Opcional)" max="255" required>
                                <small id="small" class="form-text text-muted">Segundo nombre del empleado.</small>
                            </div>
                        </div>
                        {{-- Apellidos --}}
                        <div class="row mb-3">
                            <div class="col text-center">
                                <label for="Papellido">Primer Apellido.</label>
                                <input type="text" class="form-control" id="Papellido"
                                    placeholder="Primer apellido del empleado." max="255" required>
                                <small id="small" class="form-text text-muted">Primer apellido del empleado.</small>
                            </div>
                            <div class="col text-center">
                                <label for="Sapellido">Segundo Apellido.</label>
                                <input type="text" class="form-control" id="Sapellido"
                                    placeholder="Segundo apellido del empleado. (Opcional)" max="255" required>
                                <small id="small" class="form-text text-muted">Segundo apellido del empleado.</small>
                            </div>
                        </div>
                        {{-- Contactos --}}
                        <div class="row">
                            <div class="col text-center">
                                <label for="telefono">Telefono.</label>
                                <input type="text" class="form-control" id="telefono" placeholder="4122232342"
                                    max="100" required>
                                <small id="small" class="form-text text-muted">Telefono del empleado.</small>
                            </div>
                            <div class="col text-center">
                                <label for="correo">Correo electronico.</label>
                                <input type="text" class="form-control" id="correo"
                                    placeholder="example@example.com" max="255" required>
                                <small id="small" class="form-text text-muted">Correo electronico del
                                    empleado.</small>
                            </div>
                        </div>
                        {{-- Departamento --}}
                        <div class="form-group text-center">
                            <label for="departamento_id">Asignar departamento.</label>
                            <input type="hidden" class="form-control" id="departamentoVer" readonly>
                            <select class="form-control mb-2" id="departamento_id" style="width: 100%" required>
                                @foreach ($departamentos as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" id="submit" class="btn btn-primary"><i class="fas fa-lg fa-save"></i>
                            Guarda</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@push('css')
    <style>
        .dropdown-menu.show {
            display: inline-table;
        }
    </style>
@endpush

@push('js')
    <script>
        var token = $('meta[name="csrf-token"]').attr('content');
        var rutaAccion = "";

        var table = new DataTable('#datatable', {
            ajax: '{{ route('empleados.lista') }}',
            responsive: true,
            processing: true,
            serverSide: true,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            columns: [{
                    data: 'foto',
                    name: 'foto',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (row.fotoUrl) {
                            return '<img src="' + row.fotoUrl +
                                '" width="100" height="100" alt="Imagen del empleado">';
                        } else {
                            return '<span class="text-muted">Imagen no disponible</span>';
                        }
                    }
                },
                {
                    data: 'codigo',
                    name: 'codigo',
                    className: 'text-center'
                },
                {
                    data: 'Pnombre',
                    name: 'Pnombre',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (row.Sapellido) {
                            return row.Pnombre + ' ' + row.Snombre;
                        } else {
                            return row.Pnombre;
                        }
                    }
                },
                {
                    data: 'Papellido',
                    name: 'Papellido',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (row.Sapellido) {
                            return row.Papellido + ' ' + row.Sapellido;
                        } else {
                            return row.Papellido;
                        }
                    }
                },
                {
                    data: 'departamento_id',
                    name: 'departamento_id',
                    className: 'text-center',
                    render: function(data, type, row) {
                        if (row.depa) {
                            return row.depa;
                        } else {
                            return 'Departamento Desconocido';
                        }
                    }
                },
                {
                    "data": null,
                    "width": "100px",
                    "className": "text-center",
                    "render": function(data, type, row, meta) {
                        return `
                        <div class="dropdown dropleft">
                            <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class=""></i> Accion
                            </button>
                            <div class="dropdown-menu dropdown-menu-sm" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item bg-info ver" data-id="${row.id}" href="javascript:ver(${row.id});"><i class="fa fa-file"></i> Ver</a>
                                <a class="dropdown-item bg-warning editar" data-id="${row.id}" href="javascript:editar(${row.id});"><i class="fa fa-edit"></i> Editar</a>
                                <a class="dropdown-item bg-danger eliminar" data-id="${row.id}" href="javascript:eliminar(${row.id});"><i class="fa fa-trash"></i> Eliminar</a>
                            </div>
                        </div>`;
                    },
                    "orderable": false
                },
            ],
            columnDefs: [{
                orderable: false,
                targets: [5, 0],
                responsivePriority: 1,
                responsivePriority: 2,

            }],
            language: {
                "zeroRecords": "No se encontraron resultados",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "lengthMenu": "Mostrar _MENU_ registros",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "sProcessing": "Procesando...",
            },
        });

        //  Consultas EndPoint
        consulta = function(id) {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "{{ route('empleados.consulta') }}/" + id,
                    method: "GET",
                    success: function(Data) {
                        resolve(Data);
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    }
                });
            });
        };

        // Enviar datos
        $('#formulario').submit(function(e) {
            e.preventDefault(); // Previene el recargo de la página

            var formData = new FormData(this);
            formData.append('foto', $('#foto')[0].files[0]);
            formData.append('codigo', $.trim($('#codigo').val()));
            formData.append('Pnombre', $.trim($('#Pnombre').val()));
            formData.append('Snombre', $.trim($('#Snombre').val()));
            formData.append('Papellido', $.trim($('#Papellido').val()));
            formData.append('Sapellido', $.trim($('#Sapellido').val()));
            formData.append('correo', $.trim($('#correo').val()));
            formData.append('telefono', $.trim($('#telefono').val()));
            formData.append('departamento_id', $('#departamento_id').val());

            $.ajax({
                url: rutaAccion,
                method: 'POST',
                data: formData,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': token
                },
                success: function(data) {
                    table.ajax.reload(null, false);
                    if (data.success) {
                        Swal.fire({
                            title: data.informacion,
                            text: "El registro fue " + data.accion + " al sistema",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            title: 'Empleado no registrado',
                            text: "Error en el registro",
                            icon: "error",
                            timer: 2000,
                            showConfirmButton: false,
                            timerProgressBar: true
                        });
                    }

                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: "Falla en el sistema",
                        text: "El registro no fue agregado al sistema!!",
                        icon: "error"
                    });
                }
            });

            $('#modalCRUD').modal('hide'); // Cierra el modal después de la solicitud AJAX
        });

        // ACCIONES
        crear = function() {
            rutaAccion = "{{ route('empleados.crear') }}";

            // Editar Formulario
            $("#formulario").trigger("reset");

            // readonly 
            $("#codigo").attr("readonly", false);
            $("#Pnombre").attr("readonly", false);
            $("#Snombre").attr("readonly", false);
            $("#Papellido").attr("readonly", false);
            $("#Sapellido").attr("readonly", false);
            $("#telefono").attr("readonly", false);
            $("#correo").attr("readonly", false);

            // Require
            $("#foto").attr("required", true);

            // Show
            $('#departamento_id').show()
            $('#small').show()
            $('#fotoTitle').show()
            $('#foto').show()
            $('#submit').show()

            // Hidder
            $('#departamentoVer').attr('type', 'hidden');

            // Editar Modal
            $("#titulo").html("Agregar nuevo empleado");
            $("#bg-titulo").attr("class", "modal-header bg-primary");
            $("#preview").attr("src", "{{ asset('sistema/img/empleadoNew.png') }}");
            $('#modalCRUD').modal('show');
        };

        ver = async function(id) {
            try {
                $("#formulario").trigger("reset");
                datos = await consulta(id);
                $("#titulo").html("Ver Empleado -> " + datos.codigo);
                $("#bg-titulo").attr("class", "modal-header bg-info");
                // asigancion de valores
                $("#preview").attr("src", datos.fotoUrl);
                $("#codigo").val(datos.codigo);
                $("#Pnombre").val(datos.Pnombre);
                $("#Snombre").val(datos.Snombre);
                $("#Papellido").val(datos.Papellido);
                $("#Sapellido").val(datos.Sapellido);
                $("#departamentoVer").val(datos.depa);
                $("#telefono").val(datos.telefono);
                $("#correo").val(datos.correo);
                $('#departamentoVer').attr('type', 'text');
                // readoly true
                $("#codigo").attr("readonly", true);
                $("#Pnombre").attr("readonly", true);
                $("#Snombre").attr("readonly", true);
                $("#Papellido").attr("readonly", true);
                $("#Sapellido").attr("readonly", true);
                $("#telefono").attr("readonly", true);
                $("#correo").attr("readonly", true);
                // ocultar botones y small
                $('#departamento_id').hide()
                $('#foto').hide()
                $('#fotoTitle').hide()
                $('#submit').hide()
                $('#modalCRUD').modal('show');
            } catch (error) {
                Swal.fire({
                    title: '¡ Error !',
                    text: 'Tu registro no existe.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            }
        };

        editar = async function(id) {
            rutaAccion = "{{ route('empleados.editar') }}/" + id;
            try {
                $("#formulario").trigger("reset");
                datos = await consulta(id);
                $("#titulo").html("Editar Empleado -> " + datos.codigo);
                $("#bg-titulo").attr("class", "modal-header bg-warning");
                // asigancion de valores
                $("#foto").attr("required", false);
                $("#preview").attr("src", datos.fotoUrl);
                $("#codigo").val(datos.codigo);
                $("#Pnombre").val(datos.Pnombre);
                $("#Snombre").val(datos.Snombre);
                $("#Papellido").val(datos.Papellido);
                $("#Sapellido").val(datos.Sapellido);
                $("#departamento_id").val(datos.departamento_id);
                $('#departamento_id').trigger('change');
                $("#telefono").val(datos.telefono);
                $("#correo").val(datos.correo);
                $('#departamentoVer').attr('type', 'hidden');
                // readoly true
                $("#codigo").attr("readonly", false);
                $("#Pnombre").attr("readonly", false);
                $("#Snombre").attr("readonly", false);
                $("#Papellido").attr("readonly", false);
                $("#Sapellido").attr("readonly", false);
                $("#telefono").attr("readonly", false);
                $("#correo").attr("readonly", false);
                // mostrar botones y small
                $('#departamento_id').show()
                $('#foto').show()
                $('#fotoTitle').show()
                $('#submit').show()
                $('#modalCRUD').modal('show');
            } catch (error) {
                Swal.fire({
                    title: '¡ Error !',
                    text: 'Tu registro no existe.',
                    icon: 'error',
                    timer: 2000,
                    showConfirmButton: false,
                    timerProgressBar: true,
                });
            }
        };

        eliminar = function(id) {
            Swal.fire({
                title: '¿ Estas seguro que desea eliminar el registro?',
                text: "¡ No podrás revertir esto !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡ Sí, bórralo !',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('empleados.eliminar') }}/" + id,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        success: function(data) {
                            if (data.success) {
                                table.row('#' + id).remove().draw();
                                // Mostrar mensaje de éxito con temporizador
                                Swal.fire({
                                    title: '¡ Eliminado !',
                                    text: 'Tu registro ha sido eliminado.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false,
                                    timerProgressBar: true,
                                });
                            } else {
                                // Mostrar mensaje de error
                                Swal.fire({
                                    title: '¡ Error !',
                                    text: 'Tu registro no ha sido eliminado.',
                                    icon: 'error',
                                    timer: 2000,
                                    showConfirmButton: false,
                                    timerProgressBar: true,
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                title: "Error en el sistema",
                                text: "El registro no fue agregado al sistema!!",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        };

        // FIN ACCIONES

        function previewImage() {
            const file = document.getElementById('foto').files[0];
            const preview = document.getElementById('preview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
            }
        }
    </script>
@endpush
