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
                    <th>Codigo</th>
                    <th data-priority="2">Cedula</th>
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
                    <th>Cedula</th>
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

{{-- Push extra scripts --}}

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
                    data: 'cedula',
                    name: 'cedula',
                    className: 'text-center'
                },
                {
                    data: 'nombre',
                    name: 'nombre',
                    className: 'text-center'
                },
                {
                    data: 'apellido',
                    name: 'apellido',
                    className: 'text-center'
                },
                {
                    data: 'departamento_id',
                    name: 'departamento_id',
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
                targets: [6, 0],
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
        // consulta = function(id) {
        //     return new Promise((resolve, reject) => {
        //         $.ajax({
        //         url: " /" + ,
        //         method: "GET",
        //         success: function(Data) {
        //             resolve(Data);
        //         },
        //         error: function(xhr, status, error) {
        //             reject(error);
        //         }
        //         });
        //     });
        // };

        // Enviar datos
        // $('#formulario').submit(function(e){
        //     e.preventDefault(); // Previene el recargo de la página

        //     var formData = new FormData(this);
        //     formData.append('foto', $('#foto')[0].files[0]);
        //     formData.append('codigo', $.trim($('#codigo').val()));
        //     formData.append('nombre', $.trim($('#nombre').val()));
        //     formData.append('descripcion', $.trim($('#descripcion').val()));
        //     formData.append('categoria', $.trim($('#categoria').val()));
        //     formData.append('precio', $.trim($('#precio').val()));
        //     formData.append('cantidad', $.trim($('#cantidad').val()));

        //         $.ajax({
        //         url: rutaAccion,
        //         method: 'POST',
        //         data: formData,
        //         dataType: 'JSON',
        //         contentType: false, 
        //         processData: false,
        //         cache:false,
        //         headers: {
        //             'X-CSRF-TOKEN': token
        //         },
        //         success: function(data) {
        //             table.ajax.reload(null, false);
        //             if (data.success) {
        //                 Swal.fire({
        //                 title: data.informacion,
        //                 text: "El registro fue "+data.accion+" al sistema",
        //                 icon: "success",
        //                 timer: 2000,
        //                 showConfirmButton: false,
        //                 timerProgressBar: true
        //                 }); 
        //         } else {
        //             Swal.fire({
        //             title: 'Producto no registrada',
        //             text: "Error en el registro",
        //             icon: "error",
        //             timer: 2000,
        //             showConfirmButton: false,
        //             timerProgressBar: true
        //             }); 
        //         }

        //         },
        //         error: function(xhr, status, error) {
        //         Swal.fire({
        //             title: "Producto no agregada",
        //             text: "El registro no fue agregado al sistema!!",
        //             icon: "error"
        //         });
        //         }
        //     });

        //     $('#modalCRUD').modal('hide'); // Cierra el modal después de la solicitud AJAX
        // });

        // ACCIONES
        crear = function() {
            // rutaAccion = ""; 

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
            $('#small').show()
            $('#fotoTitle').show()
            $('#foto').show()
            $('#submit').show()

            // Editar Modal
            $("#titulo").html("Agregar nuevo empleado");
            $("#bg-titulo").attr("class", "modal-header bg-primary");
            $("#preview").attr("src", "{{ asset('sistema/img/empleadoNew.png') }}");
            $('#modalCRUD').modal('show');
        };

        // ver = async function(id) {
        //     try {
        //         datos = await consulta(id);
        //         $("#titulo").html("Ver Producto -> " + datos.nombre);
        //         $("#bg-titulo").attr("class","modal-header bg-info"); 
        //         // asigancion de valores
        //         $("#preview").attr("src", datos.fotoUrl);
        //         $("#nombre").val(datos.nombre);
        //         $("#codigo").val(datos.codigo);
        //         $("#categoriaVer").val(datos.categoria);
        //         $("#descripcion").val(datos.descripcion);
        //         $("#cantidad").val(datos.cantidad);
        //         $("#precio").val(datos.precio);
        //         $('#categoriaVer').attr('type', 'text');
        //         // readoly true
        //         $("#descripcion").attr("readonly", true);
        //         $("#nombre").attr("readonly", true);
        //         $("#codigo").attr("readonly", true);
        //         $("#cantidad").attr("readonly", true);
        //         $("#precio").attr("readonly", true);
        //         // ocultar botones y small
        //         $('#categoria').hide()
        //         $('#codigoSmall').hide() 
        //         $('#nombreSmall').hide()
        //         $('#descripcionSmall').hide()
        //         $('#cantidadSmall').hide()
        //         $('#precioSmall').hide()
        //         $('#foto').hide()
        //         $('#fotoTitle').hide()
        //         $('#submit').hide()
        //         $('#modalCRUD').modal('show'); 
        //     } catch (error) {
        //         console.error("Error:", error);
        //     }
        // };

        // editar = async function(id){
        //     try {
        //         $("#formulario").trigger("reset");
        //         datos = await consulta(id);
        //         rutaAccion = "/"+id;
        //         $("#titulo").html("Editar Producto -> " + datos.nombre);
        //         $("#bg-titulo").attr("class","modal-header bg-warning"); 
        //         // Asignacion de valores
        //         $("#precio").val(datos.precio);
        //         $("#cantidad").val(datos.cantidad);
        //         $("#descripcion").val(datos.descripcion);
        //         $("#categoria").val(datos.categoria);
        //         $('#categoria').trigger('change');
        //         $("#codigo").val(datos.codigo);
        //         $("#nombre").val(datos.nombre);
        //         $("#preview").attr("src", datos.fotoUrl);
        //         // readoly false
        //         $("#codigo").attr("readonly", false);
        //         $("#nombre").attr("readonly", false);
        //         $("#descripcion").attr("readonly", false);
        //         $("#cantidad").attr("readonly", false);
        //         $("#precio").attr("readonly", false);
        //         $("#foto").attr("required", false);
        //         // mostrar botones y small
        //         $('#categoriaVer').attr('type', 'hidden');
        //         $('#categoria').show()
        //         $('#codigoSmall').show() 
        //         $('#nombreSmall').show()
        //         $('#descripcionSmall').show()
        //         $('#cantidadSmall').show()
        //         $('#precioSmall').show()
        //         $('#foto').show()
        //         $('#fotoTitle').show()
        //         $('#submit').show()
        //         $('#modalCRUD').modal('show'); 
        //     } catch (error) {
        //         console.error("Error:", error);
        //     }
        // };

        // eliminar = function(id){
        //     Swal.fire({
        //         title: '¿ Estas seguro que desea eliminar el registro?',
        //         text: "¡ No podrás revertir esto !",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: '¡ Sí, bórralo !',
        //         }).then((result) => {
        //         if (result.isConfirmed){
        //             $.ajax({
        //             url: "/"+id,
        //             method: "DELETE",
        //             headers: {
        //                 'X-CSRF-TOKEN': token
        //             },
        //             success: function(data) {
        //                 if (data.success) {
        //                 table.row('#' + id).remove().draw();
        //                 // Mostrar mensaje de éxito con temporizador
        //                 Swal.fire({
        //                     title: '¡ Eliminado !',
        //                     text: 'Tu registro ha sido eliminado.',
        //                     icon: 'success',
        //                     timer: 2000,
        //                     showConfirmButton: false,
        //                     timerProgressBar: true,
        //                 });
        //                 } else {
        //                 // Mostrar mensaje de error
        //                 Swal.fire({
        //                     title: '¡ Error !',
        //                     text: 'Tu registro no ha sido eliminado.',
        //                     icon: 'error',
        //                     timer: 2000,
        //                     showConfirmButton: false,
        //                     timerProgressBar: true,
        //                 });
        //                 }
        //             }
        //             });
        //         }
        //         });
        // };

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
