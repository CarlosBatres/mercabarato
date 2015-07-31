$(document).ready(function() {
    updateResultadosProductos();
    updateResultadosRequisitos();
});

function updateResultadosProductos() {            
    $('#tabla-resultados-productos').html('<br><br><br>');
    $('#tabla-resultados-productos').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/ofertas/ajax_get_productos_ofertados',
        data: {
            pagina: $('#pagina').val(),
            oferta_general_id: $('#og_id').val()
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-productos').unblock();
            $('#tabla-resultados-productos').html(response);
            bind_pagination_links();
        }
    });
}

function bind_pagination_links() {
    $('#tabla-resultados-productos').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultadosProductos();
    });
}

function updateResultadosRequisitos() {            
    $('#tabla-resultados-requisitos').html('<br><br><br>');
    $('#tabla-resultados-requisitos').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/ofertas/ajax_get_requisitos',
        data: {
            pagina: $('#pagina').val(),
            oferta_general_id: $('#og_id').val()
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-requisitos').unblock();
            $('#tabla-resultados-requisitos').html(response);
            bind_pagination_links2();
        }
    });
}

function bind_pagination_links2() {
    $('#tabla-resultados-requisitos').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultadosRequisitos();
    });
}