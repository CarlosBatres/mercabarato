$(document).ready(function() {
    updateResultados();
    bind_botones();

    $('#listado-item').on('submit', function(e) {
        e.preventDefault();
        $('#pagina').val('1');
        updateResultados();
    });
});

function updateResultados() {
    var form = $('#listado-item');
    var string = get_selected_checkboxes();
    form.append('<input type="hidden" name="excluir_ids" value="' + string + '">');
    form.append('<input type="hidden" name="search_main" value="true">');
    $('#tabla-resultados').html('<br><br><br><br>');
    $('#tabla-resultados').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/tarifas/ajax_get_productos',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            bind_pagination_links();
        }
    });
}

function updateResultadosTab2() {
    var incluir_ids = get_selected_checkboxes();
    $('#tabla-resultados-tarifas').html('<br><br><br><br>');
    $('#tabla-resultados-tarifas').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/tarifas/ajax_get_productos',
        data: {
            incluir_ids: incluir_ids,
            pagina: $('#pagina_tab2').val()
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-tarifas').unblock();
            $('#tabla-resultados-tarifas').html(response);
            bind_pagination_links_tab2();
        }
    });
}

function bind_pagination_links() {
    $('#tabla-resultados').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultados();
    });
}

function bind_pagination_links_tab2() {
    $('#tabla-resultados-tarifas').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina_tab2').val($(this).data('id'));
        updateResultadosTab2();
    });
}

function bind_botones() {
    $('#btn-mover').on('click', function(e) {
        e.preventDefault();
        if (get_selected_checkboxes()) {
            updateResultadosTab2();
            $('#pagina').val("1");
            updateResultados();
        }

    });
}

function get_selected_checkboxes() {
    var string = "";
    $('#tabla-resultados').find('input[name="mover"]:checked').each(function() {
        string += $(this).parents('tr').data('id');
        string += ";;";
    });
    if (string.length > 1) {
        string = string.slice(0, -2);
    }
    if (string.length === 0) {
        return false;
    } else {
        return string;
    }
}