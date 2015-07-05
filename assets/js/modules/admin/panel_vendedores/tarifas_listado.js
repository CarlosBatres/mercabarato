$(document).ready(function() {
    updateResultados();

    $('#tarifas-modificar').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            type: "POST",
            url: SITE_URL +'panel_vendedor/tarifas/modificar',
            data: form.serialize(),            
            complete: function() {
                $('#myModal').modal('hide');
                updateResultados();           
            }
        });        
    });
});

function updateResultados() {
    var form = $('#listado-productos');
    $('#tabla-resultados').html('<br><br><br>');
    $('#tabla-resultados').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/tarifas/ajax_get_listado_resultados',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            bind_pagination_links();
            bind_links();
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

function bind_links() {
    $('.table-responsive').find('.options>a').off();
    $('.table-responsive').find('.options>a').on('click', function(e) {
        var producto_id = $(this).data('id');
        $('input[name="monto"]').val('');
        $('#producto-id').val(producto_id);
    });
}