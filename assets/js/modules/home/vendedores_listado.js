$(document).ready(function() {    
    $('#search_button').on('click', function(e) {
        e.preventDefault();
        updateResultados();
    });

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
        $('#pagina').val("1");
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
        $('#pagina').val("1");
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

    //$('#form_buscar').find('select[name="pais"]').trigger('change');

    $('#myModal').on('shown.bs.modal', function(e) {
        var invoker = $(e.relatedTarget);        
        $('input[name="vendedor_id"]').val(invoker.data('id'));
    });
    
    updateResultados();
});

function updateResultados() {
    var search_query = $('input[name="search_query"]').val();
    var pagina_id = $('#pagina').val();
    //var pais = $('select[name="pais"]').val();
    var provincia = $('select[name="provincia"]').val();
    var poblacion = $('select[name="poblacion"]').val();

    $('#tabla-resultados').css('opacity', '0.5');
    $('#tabla-resultados').block({message: $('#throbber'),
        css: {width: '4%', border: '0px solid #FFFFFF', cursor: 'wait', backgroundColor: '#FFFFFF', top: '50px'},
        overlayCSS: {backgroundColor: '#FFFFFF', opacity: 0.0, cursor: 'wait'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'vendedores/buscar',
        data: {
            search_query: search_query,
            pagina: pagina_id,
            //pais: pais,
            provincia: provincia,
            poblacion: poblacion
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