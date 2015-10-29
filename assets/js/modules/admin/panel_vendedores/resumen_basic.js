$(document).ready(function() {    
    updateResultados();
    
    $('#morris_general_afiliados').html('<p> Esta opcion no esta disponible para tu navegador.</p>');
    $('#morris_general').html('<p> Esta opcion no esta disponible para tu navegador.</p>');
});

function updateResultados() {
    var form = $('#listado-productos');
    $('#tabla-productos').html('<br><br><br>');
    $('#tabla-productos').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/visitas/get_productos_visitas',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-productos').unblock();
            $('#tabla-productos').html(response);
            bind_pagination_links();
        }
    });
}

function bind_pagination_links() {
    $('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultados();
    });
}