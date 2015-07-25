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
        url: SITE_URL + 'usuario/buscar-solicitudes-seguros',
        data: {
            pagina: pagina_id
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').css('opacity', '1');
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            bind_links();
            bind_pagination_links();
        },
        error: function() {
            $('#tabla-resultados').css('opacity', '1');
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html('');
        }
    });
}

function bind_links() {
    $('#myModal').on('hidden.bs.modal', function() {        
        $(this).removeData('bs.modal');        
    });
}


function bind_pagination_links() {
    $('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultados();
    });
}