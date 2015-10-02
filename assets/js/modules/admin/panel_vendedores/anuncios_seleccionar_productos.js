$(document).ready(function() {
    if (typeof (Storage) === "undefined") {
        window.location.replace(SITE_URL + "panel_vendedor/anuncio/listado");
    } else {
        localStorage.setItem("anuncios_productos_listado_checkboxes", "");

        var chk = localStorage.getItem('anuncios_clientes_listado_checkboxes');
        if (chk === "") {
            updateResultadosEmpty();
        } else {
            updateResultados();
        }


        $('#listado-items').on('submit', function(e) {
            e.preventDefault();
            $('#pagina').val('1');
            updateResultados();
        });

        $('#siguiente').on('click', function(e) {
            e.preventDefault();
            $.blockUI({message: "<h3>Espere un momento...<h3>"});
            $.ajax({
                type: "POST",
                url: SITE_URL + 'panel_vendedor/anuncio/enviar_anuncio_invitados',
                data: {
                    anuncio_id: $('#anuncio_id').val(),
                    cliente_ids: localStorage.getItem('anuncios_clientes_listado_checkboxes'),
                    producto_ids: localStorage.getItem('anuncios_productos_listado_checkboxes')
                },
                dataType: "json",
                success: function(response) {
                    $.unblockUI();
                    window.location.replace(SITE_URL + "panel_vendedor/anuncio/listado");
                }
            });
        });
    }
});

function updateResultados() {
    var form = $('#listado-items');
    $('#tabla-resultados').html('<br><br><br>');
    $('#tabla-resultados').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/anuncio/ajax_get_productos',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            bind_pagination_links();
            //bind_check_all();
            bind_checkbox();
        }
    });
}

function updateResultadosEmpty() {
    var form = $('#listado-items');
    $('#tabla-resultados').html('<br><br><br>');
    $('#tabla-resultados').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/anuncio/ajax_get_productos',
        data: {no_results: true},
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            //bind_pagination_links();
            //bind_check_all();
            //bind_checkbox();
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

/*function bind_check_all() {
 $('#tabla-resultados').find("input[name='select_all']").click(function() {
 if ($(this).is(':checked')) {
 $('#tabla-resultados').find("input[name='seleccionar']").each(function() {
 $(this).prop("checked", true).trigger("change");
 });
 
 } else {
 $('#tabla-resultados').find("input[name='seleccionar']").each(function() {
 $(this).prop("checked", false).trigger("change");
 });
 }
 });
 }*/

function bind_checkbox() {
    $('#tabla-resultados').find("input[name='seleccionar']").on('change', function() {
        var id = $(this).parents('tr').data('id');
        var chk = localStorage.getItem('anuncios_productos_listado_checkboxes').split(";;");
        if (chk[0] === "") {
            chk = [];
        }
        var tmp;
        if ($(this).is(':checked')) {
            if (chk.length < 10) {
                chk.push(id.toString());
            } else {
                $(this).attr('checked', false);
            }
        } else {
            chk = jQuery.grep(chk, function(value) {
                return value !== id.toString();
            });
        }
        tmp = chk.join(";;");
        localStorage.setItem('anuncios_productos_listado_checkboxes', tmp);
    });

    $('#tabla-resultados').find("input[name='seleccionar']").each(function() {
        var id = $(this).parents('tr').data('id');
        var chk = localStorage.getItem('anuncios_productos_listado_checkboxes').split(";;");
        if (chk[0] != "") {
            if ($.inArray(id.toString(), chk) >= 0) {
                $(this).prop("checked", true);
            }
        }
    });
}
