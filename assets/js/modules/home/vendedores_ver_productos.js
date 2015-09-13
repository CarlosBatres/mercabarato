$(document).ready(function() {
    updateResultados();
});

function updateResultados() {
    var vendedor_id = $('input[name="vendedor_id"]').val();
    var pagina_id = $('#pagina').val();
    var grupo_txt =$('input[name="grupo_txt"]').val();
    var familia_txt =$('input[name="familia_txt"]').val();
    var subfamilia_txt =$('input[name="subfamilia_txt"]').val();

    $('#tabla-resultados').css('opacity', '0.5');
    $('#tabla-resultados').block({message: $('#throbber'),
        css: {width: '4%', border: '0px solid #FFFFFF', cursor: 'wait', backgroundColor: '#FFFFFF', top: '50px'},
        overlayCSS: {backgroundColor: '#FFFFFF', opacity: 0.0, cursor: 'wait'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'vendedores/ver_productos_listado',
        data: {            
            pagina: pagina_id,
            vendedor_id:vendedor_id,
            grupo_txt: grupo_txt,
            familia_txt: familia_txt,
            subfamilia_txt: subfamilia_txt,
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').css('opacity', '1');
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
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