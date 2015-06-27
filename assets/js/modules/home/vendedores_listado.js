$(document).ready(function() {
    updateResultados();
    //$('#producto-principal-categorias').metisMenu();    

    $('#search_button').on('click', function(e) {
        e.preventDefault();
        updateResultados();
    });

    /*$('.seleccion_categoria a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val("1");        
        if ($(this).hasClass('clicked')) {
            $(this).removeClass('clicked');            
        } else {
            $('.category-menu').find('.clicked').removeClass('clicked');
            $(this).addClass('clicked');
            updateResultados();
        }
    });*/

    /*$('#precios-search-aplicar').on('click', function(e) {
        e.preventDefault();
        updateResultados();
    });*/

});

function updateResultados() {
    var search_query = $('input[name="search_query"]').val();    
    var pagina_id = $('#pagina').val();        

    $('#tabla-resultados').html('');
    $.ajax({
        type: "POST",
        url: SITE_URL + 'home/vendedor/ajax_get_listado_resultados',
        data: {
            search_query: search_query,
            pagina: pagina_id,            
        },
        dataType: "html",
        success: function(response) {
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