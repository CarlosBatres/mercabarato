$(document).ready(function() {
    updateResultados();

    $('#listado-items').on('submit', function(e) {
        e.preventDefault();
        $('#pagina').val('1');
        updateResultados();
    });
});

function updateResultados() {
    var form = $('#listado-items');
    $('#tabla-resultados').html('<br><br><br>');
    $('#tabla-resultados').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/infocompras/ajax_get_generales',
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
    $('.table-responsive').find('.options').find('.row_action').off();
    $('.table-responsive').find('.options').find('.row_action').on('click', function(e) {        
        e.preventDefault();        
        var a_href = $(this).attr('href');        
        $.blockUI({message: $('#question'),blockMsgClass: 'modal-confimacion'});
        
        if ($(this).hasClass('borrar')) {
            $('#question').find('.modal-title').html("Estas seguro que deseas eliminar esta solicitud de infocompra?.");
            $('#question').find('.contenido-mensaje').html("Se eliminaran todos los mensajes y archivos asociados a esta solicitud permanentemente.");
        }else if($(this).hasClass('cerrar')){
            $('#question').find('.modal-title').html("Estas seguro que deseas cerrar esta solicitud de infocompra?.");
            $('#question').find('.contenido-mensaje').html("Al cerrar la solicitud no se podran intercambiar mas mensajes.");
        }
        
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