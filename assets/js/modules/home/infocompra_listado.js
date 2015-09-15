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
        url: SITE_URL + 'infocompras/buscar-vendedores',
        data: {
            pagina: pagina_id,            
        },
        dataType: "json",
        success: function(response) {
            $('#tabla-resultados').css('opacity', '1');
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response.html);
            bind_pagination_links();
            bind_botones();
            if (response.result === "success") {
                enviar_todos();
            } else if (response.result === "empty") {
                $('.enviar-todos-btn').css('display', 'none');
            }

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

function bind_botones() {
    $('.enviar_presupuesto').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.post(SITE_URL + "infocompras/enviar", {id: id}).done(function() {
            updateResultados();
            $('.terminar-btn').css('display', 'block');
        });
    });
}