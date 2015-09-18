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
            solo_ignore_list:'1',
            layout:'2'
        },
        dataType: "json",
        success: function(response) {
            $('#tabla-resultados').css('opacity', '1');
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response.html);
            bind_pagination_links();            
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