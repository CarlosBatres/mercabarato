$(document).ready(function() {
    updateResultados();

    $('#search_button').on('click', function(e) {
        e.preventDefault();
        updateResultados();
    });

    $('.seleccion_categoria a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val("1");
        if ($(this).parent().hasClass('active')) {
            $(this).parent().removeClass('active');
            updateResultados();
        } else {
            $('.category-menu').find('li.active').removeClass('active');
            $(this).parent().addClass('active');
            updateResultados();
        }
    });

    $('#precios-search-aplicar').on('click', function(e) {
        e.preventDefault();
        updateResultados();
    });

});

function updateResultados() {
    var search_query = $('input[name="search_query"]').val();
    var categoria_id = $('.category-menu').find('li.active a').data('id');
    var pagina_id = $('#pagina').val();
    var categoria_padre = $('input[name="categoria_padre"]').val();
    var precio = 0;

    $.each($('input[name="precios"]'), function(index,checkbox) {
        if ($(this).is(":checked")) {
            precio=checkbox.value;
        }        
    });        

    if (typeof categoria_id === "undefined") {
        categoria_id = "";
    }

    $('#tabla-resultados').html('');
    $.ajax({
        type: "POST",
        url: SITE_URL + 'home/producto/ajax_get_listado_resultados',
        data: {
            search_query: search_query,
            categoria_id: categoria_id,
            pagina: pagina_id,
            categoria_padre: categoria_padre,
            precio_tipo1:precio
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