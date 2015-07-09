$(document).ready(function() {
    updateResultadosProductos();
    updateResultadosDetalles(0);
    
    $('#listado-items').on('submit', function(e) {
        e.preventDefault();
        $('#pagina').val('1');        
        updateResultadosProductos();
        updateResultadosDetalles(0);
    });
});

function updateResultadosProductos(){
    var form = $('#listado-items');            
    form.append('<input type="hidden" name="solo_tarifados" value="true">');
    $('#tabla-resultados-left').html('<br><br><br><br>');
    $('#tabla-resultados-left').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/tarifas/ajax_get_productos_tarifados',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-left').unblock();
            $('#tabla-resultados-left').html(response);
            bind_pagination_links();
            bind_producto_row();
        }
    });    
}

function bind_pagination_links() {
    $('#tabla-resultados-left').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultadosProductos();
    });
}

function bind_pagination_links_right(producto_id) {
    $('#tabla-resultados-right').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina_tab2').val($(this).data('id'));
        updateResultadosDetalles(producto_id);
    });
}

function bind_producto_row(){
    $('#tabla-resultados-left').find('.producto-tarifado').on('click',function(){        
        $('#pagina_tab2').val('1');
        updateResultadosDetalles($(this).data('id'));
    });
}

function updateResultadosDetalles(producto_id){        
    $('#tabla-resultados-right').html('<br><br><br><br>');
    $('#tabla-resultados-right').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/tarifas/ajax_get_tarifa_detalles',
        data: {
            producto_id:producto_id,
            pagina:$('#pagina_tab2').val()
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-right').unblock();
            $('#tabla-resultados-right').html(response);
            bind_pagination_links_right(producto_id);
            bind_links();
        }
    });    
}

function bind_links() {
    $('.row_action_borrar').off();
    $('.row_action_borrar').on('click', function(e) {
        e.preventDefault();
        var a_href = $(this).attr('href');
        $.blockUI({message: $('#question'), css: {}});        

        $('#yes').off();
        $('#yes').click(function() {
            $.ajax({
                url: a_href,
                cache: false,
                complete: function() {
                    updateResultadosProductos();
                    updateResultadosDetalles('0');
                    $.unblockUI();
                }
            });
        });
        $('#no').click(function() {
            $.unblockUI();
            return false;
        });
    });

}