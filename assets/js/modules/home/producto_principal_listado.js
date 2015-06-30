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
    
    $('#form_buscar').find('select[name="pais"]').on('change', function() {
        $('#form_buscar').find('select[name="provincia"]').html("<option value='0'>Todas las Provincias</option>");
        $('#form_buscar').find('select[name="poblacion"]').html("<option value='0'>Todas las Poblaciones</option>");
        var pais_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'home/provincia/ajax_get_provincias_htmlselect',
            data: {pais_id: pais_id},
            dataType: 'json',
            success: function(response) {                
                $('#form_buscar').find('select[name="provincia"]').html(response.html);                
                $('#form_buscar').find('select[name="provincia"]').find('option:first').text("Todas las Provincias");
            }
        });
    });

    $('#form_buscar').find('select[name="provincia"]').on('change', function() {
        $('#form_buscar').find('select[name="poblacion"]').html("<option value='0'>Todas las Poblaciones</option>");
        var provincia_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'home/poblacion/ajax_get_poblaciones_htmlselect',
            data: {provincia_id: provincia_id},
            dataType: 'json',
            success: function(response) {
                $('#form_buscar').find('select[name="poblacion"]').html(response.html);
                $('#form_buscar').find('select[name="poblacion"]').find('option:first').text("Todas las Poblaciones");
            }
        });
    }); 
    
    $('#form_buscar').find('select[name="pais"]').trigger('change');

});

function updateResultados() {
    var search_query = $('input[name="search_query"]').val();
    var categoria_id = $('#producto-principal-categorias').find('.clicked').data('id');
    var pais = $('select[name="pais"]').val();
    var provincia = $('select[name="provincia"]').val();
    var poblacion = $('select[name="poblacion"]').val();
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
            alt_layout: true,
            pais : pais,
            provincia : provincia,
            poblacion : poblacion
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