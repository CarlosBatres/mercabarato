$(document).ready(function() {
    $('.modificar').on('click', function(e) {
        e.preventDefault();
        $(this).parent().parent().find('input').prop("disabled", false);
        $(this).parent().parent().find('select').prop("disabled", false);
    });

    $('#modificar-paquete-pendiente').on('click', function(e) {
        e.preventDefault();
        $(this).parents('form').find('input[name="accion"]').val("modificar-paquete-pendiente");
        $(this).parents('form').submit();
    });

    $('#eliminar-paquete-pendiente').on('click', function(e) {
        e.preventDefault();
        $(this).parents('form').find('input[name="accion"]').val("eliminar-paquete-pendiente");
        $(this).parents('form').submit();
    });

    $('#aprobar-paquete-pendiente').on('click', function(e) {
        e.preventDefault();
        $(this).parents('form').find('input[name="accion"]').val("aprobar-paquete-pendiente");
        $(this).parents('form').submit();
    });


    $('#modificar-paquete-curso').on('click', function(e) {
        e.preventDefault();
        $(this).parents('form').find('input[name="accion"]').val("modificar-paquete-curso");
        $(this).parents('form').submit();
    });

    $('#eliminar-paquete-curso').on('click', function(e) {
        e.preventDefault();
        $(this).parents('form').find('input[name="accion"]').val("eliminar-paquete-curso");
        $(this).parents('form').submit();
    });

});