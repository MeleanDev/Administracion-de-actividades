@extends('adminlte.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Departamentos')
@section('content_header_title', 'Departamentos')
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
            Agregar Departamento
        </button>
    </div>
    <div class="container mt-4">
        <table class="table table-striped table-hover display responsive nowrap" cellspacing="0" id="datatable"
            style="width: 100%">
            <thead class="bg-info">
                <tr>
                    <th style="width: 50%">Departamentos</th>
                    <th style="width: 50%" class="text-center">Accion</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot class="bg-info">
                <tr>
                    <th style="width: 50%">Departamentos</th>
                    <th style="width: 50%" class="text-center">Accion</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="empleado" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="min-width: 600px">
            <div class="modal-content">
                <form id="formulario" enctype="application/x-www-form-urlencoded">
                    @csrf
                    <div class="modal-header" id="bg-titulo">
                        <h5 class="modal-title" id="titulo"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group text-center">
                            <label for="nombre">Nombre del departamento.</label>
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre del departamento."
                                required>
                            <small id="small" class="form-text text-muted">Nombre para el nuevo departamento.</small>
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

{{-- Push extra scripts --}}

@push('js')
    <script>
        var token = $('meta[name="csrf-token"]').attr('content');
        var rutaAccion = "";

        var table = new DataTable('#datatable', {
            ajax: '{{ route('departamentos.lista') }}',
            responsive: true,
            processing: true,
            serverSide: true,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            columns: [{
                    data: 'nombre',
                    name: 'nombre',
                    className: 'text-center'
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
                targets: [1],

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
                    url: "{{ route('departamentos.consulta') }}/" + id,
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
            formData.append('nombre', $.trim($('#nombre').val()));

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
                    if (data.success) {
                        table.ajax.reload(null, false);
                        Swal.fire({
                            title: data.informacion,
                            text: "El registro fue " + data.accion + " en el sistema",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            title: "Registro no guardado",
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
                        title: "Fallo en el sistema",
                        text: "El registro no fue agregado por falla en el sistema",
                        icon: "error"
                    });
                }
            });

            $('#modalCRUD').modal('hide'); // Cierra el modal después de la solicitud AJAX
        });

        // ACCIONES
        crear = function() {
            // Ruta accion
            rutaAccion = "{{ route('departamentos.crear') }}";

            // Editar Formulario
            $("#formulario").trigger("reset");

            // Editar Modal
            $("#titulo").html("Agregar nuevo departamento");
            $("#bg-titulo").attr("class", "modal-header bg-primary");
            $('#modalCRUD').modal('show');
        };

        editar = async function(id) {
            try {
                $("#formulario").trigger("reset");
                datos = await consulta(id);
                rutaAccion = "{{route('departamentos.editar')}}/" + id;
                $("#titulo").html("Editar Departamento -> " + datos.nombre);
                $("#bg-titulo").attr("class", "modal-header bg-warning");
                // Asignacion de valores
                $("#nombre").val(datos.nombre);
                $('#modalCRUD').modal('show');
            } catch (error) {
                Swal.fire({
                    title: '¡ Error !',
                    text: 'Problemas con el sistema.',
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
                        url: "{{ route('departamentos.eliminar') }}/" + id,
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
    </script>
@endpush
