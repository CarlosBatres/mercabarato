$(document).ready(function() {
    updateResultados();
});

function updateResultados() {    
    var pagina_id = $('#pagina').val();        

    $('#tabla-resultados').css('opacity', '0.5');
    $('#tabla-resultados').block({message: $('#throbber'),
        css: {width: '4%', border: '0px solid #FFFFFF', cursor: 'wait', backgroundColor: '#FFFFFF', top: '50px'},
        overlayCSS: {backgroundColor: '#FFFFFF', opacity: 0.0, cursor: 'wait'}
    });
    
    $.ajax({
        type: "POST",
        url: SITE_URL + 'home/cliente/ajax_get_listado_resultados',
        data: {            
            pagina: pagina_id            
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').css('opacity', '1');
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            bind_links();
        },
        error: function(){
            $('#tabla-resultados').css('opacity', '1');
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html('');
        }
    });
}

function bind_links() {
    $('.accion').on('click', function() {
        var invitacion_id = $(this).data('id');
        if ($(this).hasClass('aceptar')) {
            $.ajax({
                type: "POST",
                url: SITE_URL + 'home/cliente/aceptar_invitacion',
                data: {invitacion_id: invitacion_id},
                dataType: 'json',
                success: function(response) {
                    updateResultados();
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: SITE_URL + 'home/cliente/rechazar_invitacion',
                data: {invitacion_id: invitacion_id},
                dataType: 'json',
                success: function(response) {
                    updateResultados();
                }
            });
        }
    });
}