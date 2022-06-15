function init() {

}

$(document).ready(function () {
    var incidencia_id = getUrlParameter('ID');

    listardetalle(incidencia_id);

    $('#incid_descrip').summernote({
        height: 400,
        lang: "es-ES",
        callbacks: {
            onImageUpload: function (image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
                console.log("Text detect...");
            }
        },
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

    $('#incid_descripusu').summernote({
        height: 400,
        lang: "es-ES",
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
    });

    $('#incid_descripusu').summernote('disable');

    tabla = $('#documentos_data').dataTable({
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
            url: window.ruta_app + '/portal/DetalleIncidencia/documento.php?op=listar',
            type: "post",
            data: { incidencia_id: incidencia_id },
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

});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

$(document).on("click", "#btnenviar", function () {
    var incidencia_id = getUrlParameter('ID');
    var usu_id = $('#user_idx').val();
    var incid_descrip = $('#incid_descrip').val();

    if ($('#incid_descrip').summernote('isEmpty')) {
        swal("Advertencia!", "Falta Descripción", "warning");
    } else {
        $.post(window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=insertdetalle", { incidencia_id: incidencia_id, usu_id: usu_id, incid_descrip: incid_descrip }, function (data) {
            listardetalle(incidencia_id);
            $('#incid_descrip').summernote('reset');
            swal("Correcto!", "Registrado Correctamente", "success");
        });
    }
});

$(document).on("click", "#btncerrarincidencia", function () {
    swal({
        title: "Incidencias",
        text: "¿Está seguro de cerrar la incidencia?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
        function (isConfirm) {
            if (isConfirm) {
                var incidencia_id = getUrlParameter('ID');
                var usu_id = $('#user_idx').val();
                $.post(window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=update", { incidencia_id: incidencia_id, usu_id: usu_id }, function (data) {

                });

                listardetalle(incidencia_id);

                swal({
                    title: "Cerrada",
                    text: "incidencia cerrada correctamente",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });
            }
        });
});

function listardetalle(incidencia_id) {
    $.post(window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=listardetalle", { incidencia_id: incidencia_id }, function (data) {
        $('#lbldetalle').html(data);
    });

    $.post(window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=mostrar", { incidencia_id: incidencia_id }, function (data) {
        data = JSON.parse(data);
        $('#lblestado').html(data.incidencia_estado);
        $('#lblnomusuario').html(data.usu_nom + ' ' + data.usu_ape);
        $('#lblfechcrea').html(data.fech_crea);

        $('#lblnomidincidencia').html("Detalle incidencia - " + data.incidencia_id);

        $('#cat_nom').val(data.cat_nom);
        $('#incidencia_titulo').val(data.incidencia_titulo);
        $('#incid_descripusu').summernote('code', data.incidencia_descrip);

        console.log(data.incidencia_estado_texto);
        if (data.incidencia_estado_texto == "Cerrada") {
            $('#pnldetalle').hide();
        }
    });
}

init();
