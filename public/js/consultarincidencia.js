var tabla;
var usu_id = $('#user_idx').val();
var rol_id = $('#rol_idx').val();

function init() {
    $("#incidencia_form").on("submit", function (e) {
        guardar(e);
    });
}

$(document).ready(function () {

    $.post(window.ruta_app + "/portal/MntUsuario/usuario.php?op=combo", function (data) {
        $('#usu_asig').html(data);
    });

    if (rol_id == 1) {
        tabla = $('#incidencia_data').dataTable({
            "aProcessing": true,
            "aServerSide": true,
            dom: 'Bfrtip',
            "searching": true,
            lengthChange: false,
            colReorder: true,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "ajax": {
                url: window.ruta_app + '/portal/ConsultarIncidencia/incidencia.php?op=listar_x_usu',
                type: "post",
                dataType: "json",
                data: { usu_id: usu_id },
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "ordering": false,
            "bDestroy": true,
            "responsive": true,
            "bInfo": true,
            "iDisplayLength": 10,
            "autoWidth": false,
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        }).DataTable();
    } else {
        tabla = $('#incidencia_data').dataTable({
            "aProcessing": true,
            "aServerSide": true,
            dom: 'Bfrtip',
            "searching": true,
            lengthChange: false,
            colReorder: true,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "ajax": {
                url: window.ruta_app + '/portal/ConsultarIncidencia/incidencia.php?op=listar',
                type: "post",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "responsive": true,
            "bInfo": true,
            "iDisplayLength": 10,
            "autoWidth": false,
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        }).DataTable();
    }

});

function ver(incidencia_id) {
    window.open(window.ruta_app + '/portal/DetalleIncidencia/?ID=' + incidencia_id + '');
}

function asignar(incidencia_id) {
    $.post(window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=mostrar", { incidencia_id: incidencia_id }, function (data) {
        data = JSON.parse(data);
        $('#incidencia_id').val(data.incidencia_id);

        $('#mdltitulo').html('Asignar Agente');
        $("#modalasignar").modal('show');
    });

}

function guardar(e) {
    e.preventDefault();
    var formData = new FormData($("#incidencia_form")[0]);
    $.ajax({
        url: window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=asignar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            var incidencia_id = $('#incidencia_id').val();

            swal("Correcto!", "Asignado Correctamente", "success");

            $("#modalasignar").modal('hide');
            $('#incidencia_data').DataTable().ajax.reload();
        }
    });
}

function CambiarEstado(incidencia_id) {
    swal({
        title: "Incidencias",
        text: "Está seguro de reabrir la incidencia?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
        function (isConfirm) {
            if (isConfirm) {
                $.post(window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=reabrir", { incidencia_id: incidencia_id, usu_id: usu_id }, function (data) {

                });

                $('#incidencia_data').DataTable().ajax.reload();

                swal({
                    title: "Incidencia abierta",
                    text: "Incidencia abierta",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });
            }
        });
}

init();