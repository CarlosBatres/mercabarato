$(document).ready(function() {
    localStorage.setItem("anuncios_clientes_listado_checkboxes", "");
    updateResultados();

    $('#listado-items').on('submit', function(e) {
        e.preventDefault();
        $('#pagina').val('1');
        updateResultados();
    });
    
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
        url: SITE_URL + 'panel_vendedor/anuncio/ajax_get_invitados',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            bind_pagination_links();
            bind_check_all();
            bind_checkbox();
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

function bind_check_all() {
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
}

function bind_checkbox() {
    $('#tabla-resultados').find("input[name='seleccionar']").on('change', function() {
        var id = $(this).parents('tr').data('id');
        var chk = localStorage.getItem('anuncios_clientes_listado_checkboxes').split(";;");
        if (chk[0] === "") {
            chk = [];
        }
        var tmp;
        if ($(this).is(':checked')) {
            chk.push(id.toString());
        } else {
            chk = jQuery.grep(chk, function(value) {
                return value !== id.toString();
            });
        }
        tmp = chk.join(";;");
        localStorage.setItem('anuncios_clientes_listado_checkboxes', tmp);
    });

    $('#tabla-resultados').find("input[name='seleccionar']").each(function() {
        var id = $(this).parents('tr').data('id');
        var chk = localStorage.getItem('anuncios_clientes_listado_checkboxes').split(";;");
        if (chk[0] != "") {
            if ($.inArray(id.toString(), chk) >= 0) {
                $(this).prop("checked", true);
            }
        }
    });
}
