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
        url: SITE_URL + 'panel_vendedor/invitaciones/ajax_invitaciones_recibidas',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            bind_pagination_links();           
            bind_modal();
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

function bind_modal() {
    $('#question').on('hidden.bs.modal', function() {
        $(this).removeData('bs.modal');
    });

    $('#question').on('loaded.bs.modal', function() {         
        var invitacion_id=$('input[name="invitacion_id"]').val();                
        $('#yes').on('click',function() {
            $.ajax({
                url: SITE_URL+'panel_vendedor/invitaciones/aceptar/'+invitacion_id,
                cache: false,
                complete: function() {
                    $('#question').modal('hide');
                    updateResultados();                    
                }
            });
        });                
        $('#no').on('click',function() {
            $.ajax({
                url: SITE_URL+'panel_vendedor/invitaciones/rechazar/'+invitacion_id,
                cache: false,
                complete: function() {
                    $('#question').modal('hide');
                    updateResultados();                    
                }
            });
        });
    });
}
