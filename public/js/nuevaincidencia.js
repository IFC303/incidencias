
function init() {

    $("#incidencia_form").on("submit", function (e) {
        guardaryeditar(e);
    });

}

$(document).ready(function () {
    $('#incidencia_descrip').summernote({
        height: 150,
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

    $.post(window.ruta_app + "/portal/NuevaIncidencia/departamento.php?op=combo", function (data, status) {
        $('#cat_id').html(data);
    });

});

function guardaryeditar(e) {
    e.preventDefault();
    var formData = new FormData($("#incidencia_form")[0]);
    if ($('#incidencia_descrip').summernote('isEmpty') || $('#incidencia_titulo').val() == '') {
        swal("Advertencia!", "Campos Vacios", "warning");
    } else {
        var totalfiles = $('#fileElem').val().length;
        for (var i = 0; i < totalfiles; i++) {
            formData.append("files[]", $('#fileElem')[0].files[i]);
        }

        $.ajax({
            url: window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=insert",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                data = JSON.parse(data);
                console.log(data[0].incidencia_id);

                $('#incidencia_titulo').val('');
                $('#incidencia_descrip').summernote('reset');
                swal("Correcto!", "Registrado Correctamente", "success");
            }
        });
    }
}

init();