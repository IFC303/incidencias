function init() {
}

$(document).ready(function () {

});

$(document).on("click", "#btntecnico", function () {
    if ($('#rol_id').val() == 1) {
        $('#lbltitulo').html("Login Técnico");
        $('#btntecnico').html("Login Profesor");
        $('#rol_id').val(2);
        $("#imgtipo").attr("src", "public/2.jpg");
    } else {
        $('#lbltitulo').html("Login Profesor");
        $('#btntecnico').html("Login Técnico");
        $('#rol_id').val(1);
        $("#imgtipo").attr("src", "public/1.jpg");
    }
});

init();