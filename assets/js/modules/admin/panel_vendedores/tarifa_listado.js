$(document).ready(function() {
    updateResultados();
    
    
    $('#listado-items').on('submit', function(e) {
        e.preventDefault();
        $('#pagina').val('1');        
        updateResultadosProductos();        
    });
});

function updateResultados(){
    var form = $('#listado-items');            
    form.append('<input type="hidden" name="solo_tarifados" value="true">');
    $('#tabla-resultados-left').html('<br><br><br><br>');
    $('#tabla-resultados-left').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/tarifas/ajax_get_tarifas',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-left').unblock();
            $('#tabla-resultados-left').html(response);
            bind_pagination_links();
            bind_links();
        }
    });    
}

function bind_pagination_links() {
    $('#tabla-resultados-left').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultados();
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
                    updateResultados();                    
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