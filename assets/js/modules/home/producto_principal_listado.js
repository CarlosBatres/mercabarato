$(document).ready(function() {
    //updateResultados();
    $('[data-toggle="tooltip"]').tooltip();
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

        $('#producto-principal-categorias').find('.clicked').removeClass('clicked');
        $(this).parent('li').toggleClass("clicked");

        $(this).parent('li').find(".active").removeClass("active");
        $(this).parent('li').find(".in").removeClass("in");

        if (!$(this).parent('li').hasClass('active') && $(this).parent('li').hasClass("clicked") && !$(this).parent('li').hasClass('final')) {
            $(this).parent('li').removeClass('clicked');
            $(this).closest('li.active').addClass("clicked");
        }
        updateResultados();
    });

    /*$('.precios_checkbox').find("input[type='checkbox']").change(function() {
     $('.precios_checkbox').find("input[type='checkbox']").not(this).prop('checked', false);
     updateResultados();
     });*/

    $('input[name="search_query"]').keydown(function(e) {
        var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
        if (key == 13) {
            e.preventDefault();
            updateResultados();
        }
    });

    /*$('#form_buscar').find('select[name="pais"]').on('change', function() {
        $('#form_buscar').find('select[name="provincia"]').html("<option value='0'>Todas las Provincias</option>");
        $('#form_buscar').find('select[name="poblacion"]').html("<option value='0'>Todas las Poblaciones</option>");
        var pais_id = $(this).val();
        updateResultados();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'util/get_provincias',
            data: {pais_id: pais_id},
            dataType: 'json',
            success: function(response) {
                $('#form_buscar').find('select[name="provincia"]').html(response.html);
                $('#form_buscar').find('select[name="provincia"]').find('option:first').text("Todas las Provincias");
            }
        });
    });*/

    $('#form_buscar').find('select[name="provincia"]').on('change', function() {
        $('#form_buscar').find('select[name="poblacion"]').html("<option value='0'>Todas las Poblaciones</option>");
        var provincia_id = $(this).val();
        updateResultados();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'util/get_poblaciones',
            data: {provincia_id: provincia_id},
            dataType: 'json',
            success: function(response) {
                $('#form_buscar').find('select[name="poblacion"]').html(response.html);
                $('#form_buscar').find('select[name="poblacion"]').find('option:first').text("Todas las Poblaciones");
            }
        });
    });

    $('#form_buscar').find('select[name="poblacion"]').on('change', function() {
        updateResultados();
    });

    updateResultados();
    //$('#form_buscar').find('select[name="provincia"]').trigger('change');        
});

function updateResultados() {
    var search_query = $('input[name="search_query"]').val();
    var categoria_id = $('#producto-principal-categorias').find('.clicked').find('a').data('id');
    //var pais = $('select[name="pais"]').val();
    var provincia = $('select[name="provincia"]').val();
    var poblacion = $('select[name="poblacion"]').val();
    var pagina_id = $('#pagina').val();
    var mostrar_solo_tarifas = $('input[name="mostrar_mis_tarifas"]').is(":checked");
    var mostrar_solo_vendedores = $('input[name="mostrar_mis_vendedores"]').is(":checked");

    var precio_desde = $('input[name="precio_desde"]').val();

    if (!$.isNumeric(precio_desde)) {
        if (precio_desde !== "") {
            $('input[name="precio_desde"]').val("");
            $('input[name="precio_desde"]').toggleClass("invalid-precio");
        }
        precio_desde = "";        
    } else {
        $('input[name="precio_desde"]').removeClass("invalid-precio");
    }

    var precio_hasta = $('input[name="precio_hasta"]').val();

    if (!$.isNumeric(precio_hasta)) {
        if (precio_hasta !== "") {
            $('input[name="precio_hasta"]').val("");
            $('input[name="precio_hasta"]').toggleClass("invalid-precio");
        }
        precio_hasta = "";
    } else {
        $('input[name="precio_hasta"]').removeClass("invalid-precio");
    }

//    var precio = 0;
//
//    $.each($('input[name="precios"]'), function(index, checkbox) {
//        if ($(this).is(":checked")) {
//            precio = checkbox.value;
//        }
//    });

    if (typeof categoria_id === "undefined") {
        categoria_id = "";
    }

    $('#tabla-resultados').css('opacity', '0.5');
    $('#tabla-resultados').block({message: $('#throbber'),
        css: {width: '4%', border: '0px solid #FFFFFF', cursor: 'wait', backgroundColor: '#FFFFFF', top: '50px'},
        overlayCSS: {backgroundColor: '#FFFFFF', opacity: 0.0, cursor: 'wait'}
    });

    /*$('#tabla-resultados').block({
     message: $('#throbber'),
     css: {border: '0'}});*/
    $.ajax({
        type: "POST",
        url: SITE_URL + 'productos/buscar',
        data: {
            search_query: search_query,
            categoria_id: categoria_id,
            pagina: pagina_id,
            //precio_tipo1: precio,
            alt_layout: true,
            //pais: pais,
            provincia: provincia,
            poblacion: poblacion,
            mostrar_solo_tarifas: mostrar_solo_tarifas,
            mostrar_solo_vendedores: mostrar_solo_vendedores,
            precio_desde: precio_desde,
            precio_hasta: precio_hasta
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').css('opacity', '1');
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            bind_pagination_links();
        },
        error: function(result) {
            $('#tabla-resultados').css('opacity', '1');
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html("<p> Ocurrio un error, refresque su navegador...</p>");
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