$(document).ready(function() {
    $('.accion').on('click', function() {
        var invitacion_id=$(this).data('id');
        if ($(this).hasClass('aceptar')) {            
            $.ajax({
                type: "POST",
                url: SITE_URL + 'home/cliente/aceptar_invitacion',
                data: {invitacion_id: invitacion_id},
                dataType: 'json',
                success: function(response) {
                    window.location.replace(SITE_URL+"usuario/invitaciones");
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: SITE_URL + 'home/cliente/rechazar_invitacion',
                data: {invitacion_id: invitacion_id},
                dataType: 'json',
                success: function(response) {
                    window.location.replace(SITE_URL+"usuario/invitaciones");
                }
            });
        }
    });
});