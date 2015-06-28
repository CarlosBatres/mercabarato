$(document).ready(function() {
    updateResultados();
    $('#producto-principal-categorias').metisMenu();

    $('#search_button').on('click', function(e) {
        e.preventDefault();
        updateResultados();
    });
    /**
     * Evento del click en categoria
     * Agrega clase click al link que se clickea , si se colapsa una categoria busca el padre mas cercano
     */
    $('.seleccion_categoria a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val("1");

        $('#producto-principal-categorias').find('a.clicked').removeClass('clicked');
        $(this).toggleClass("clicked");

        $(this).parent('li').find(".active").removeClass("active");
        $(this).parent('li').find(".in").removeClass("in");

        if (!$(this).parent('li').hasClass('active') && $(this).hasClass("clicked") && !$(this).parent('li').hasClass('final')) {
            $(this).removeClass('clicked');
            $(this).closest('li.active').children('a').addClass("clicked");
        }
        updateResultados();
    });

    $('.checkbox').find("input[type='checkbox']").change(function() {
        $('.checkbox').find("input[type='checkbox']").not(this).prop('checked', false);
        updateResultados();
    });

    $('input[name="search_query"]').keydown(function(e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        if (key == 13) {
            e.preventDefault();
            updateResultados();
        }
    });

});

function updateResultados() {
    var search_query = $('input[name="search_query"]').val();
    var categoria_id = $('#producto-principal-categorias').find('.clicked').data('id');
    //console.log(categoria_id);
    var pagina_id = $('#pagina').val();
    var precio = 0;

    $.each($('input[name="precios"]'), function(index, checkbox) {
        if ($(this).is(":checked")) {
            precio = checkbox.value;
        }
    });

    if (typeof categoria_id === "undefined") {
        categoria_id = "";
    }

    $('#tabla-resultados').html('');
    $('#tabla-resultados').block({
        message: $('#throbber'),
        css: {border: '0', width: '100%', height: '100px'}});
    $.ajax({
        type: "POST",
        url: SITE_URL + 'home/producto/ajax_get_listado_resultados',
        data: {
            search_query: search_query,
            categoria_id: categoria_id,
            pagina: pagina_id,
            precio_tipo1: precio,
            alt_layout: true
        },
        dataType: "html",
        success: function(response) {
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