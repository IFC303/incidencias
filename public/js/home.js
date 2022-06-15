function init() {

}

$(document).ready(function () {
    var usu_id = $('#user_idx').val();

    if ($('#rol_idx').val() == 1) {
        $.post(window.ruta_app + "/portal/MntUsuario/usuario.php?op=total", { usu_id: usu_id }, function (data) {
            data = JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });

        $.post(window.ruta_app + "/portal/MntUsuario/usuario.php?op=totalabierta", { usu_id: usu_id }, function (data) {
            data = JSON.parse(data);
            $('#lbltotalabierta').html(data.TOTAL);
        });

        $.post(window.ruta_app + "/portal/MntUsuario/usuario.php?op=totalcerrada", { usu_id: usu_id }, function (data) {
            data = JSON.parse(data);
            $('#lbltotalcerrada').html(data.TOTAL);
        });

        $.post(window.ruta_app + "/portal/MntUsuario/usuario.php?op=grafico", { usu_id: usu_id }, function (data) {
            data = JSON.parse(data);

            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['Value'],
                barColors: ["#1AB244"],
            });
        });

    } else {
        $.post(window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=total", function (data) {
            data = JSON.parse(data);
            $('#lbltotal').html(data.TOTAL);
        });

        $.post(window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=totalabierta", function (data) {
            data = JSON.parse(data);
            $('#lbltotalabierta').html(data.TOTAL);
        });

        $.post(window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=totalcerrada", function (data) {
            data = JSON.parse(data);
            $('#lbltotalcerrada').html(data.TOTAL);
        });

        $.post(window.ruta_app + "/portal/ConsultarIncidencia/incidencia.php?op=grafico", function (data) {
            data = JSON.parse(data);

            new Morris.Bar({
                element: 'divgrafico',
                data: data,
                xkey: 'nom',
                ykeys: ['total'],
                labels: ['Value']
            });
        });

    }


});

init();