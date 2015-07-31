$(document).ready(function() {
    updateResultados();
});

function updateResultados() {            
    $('#tabla-resultados-clientes').html('<br><br><br>');
    $('#tabla-resultados-clientes').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/ofertas/ajax_get_clientes_oferta',
        data: {
            pagina: $('#pagina').val(),
            oferta_general_id: $('#og_id').val()
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-clientes').unblock();
            $('#tabla-resultados-clientes').html(response);
            bind_pagination_links();
        }
    });
}

function bind_pagination_links() {
    $('#tabla-resultados-clientes').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultados();
    });
}
