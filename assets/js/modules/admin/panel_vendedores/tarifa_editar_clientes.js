$(document).ready(function() {
    updateResultadosClientes();
    updateResultadosClientesDisponibles();
    bind_botones();
});

function updateResultadosClientes() {
    $('#tabla-resultados-clientes-tarifados').html('<br><br><br>');
    $('#tabla-resultados-clientes-tarifados').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/tarifas/ajax_get_clientes_tarifados',
        data: {
            pagina: $('#pagina').val(),
            tarifa_general_id: $('#tg_id').val(),
            sexo: "X",
            show_checkboxes: true
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-clientes-tarifados').unblock();
            $('#tabla-resultados-clientes-tarifados').html(response);
            bind_pagination_links();

            $('#tabla-resultados-clientes-tarifados').find("input[name='select_all']").click(function() {
                if ($(this).is(':checked')) {
                    $('#tabla-resultados-clientes-tarifados').find("input[name='mover']").each(function() {
                        $(this).prop("checked", true);
                    });

                } else {
                    $('#tabla-resultados-clientes-tarifados').find("input[name='mover']").each(function() {
                        $(this).prop("checked", false);
                    });
                }
            });
        }
    });
}

function updateResultadosClientesDisponibles() {
    $('#tabla-resultados-clientes-disponibles').html('<br><br><br>');
    $('#tabla-resultados-clientes-disponibles').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/tarifas/ajax_get_clientes',
        data: {
            pagina: $('#pagina').val(),
            ignore_tarifa_general_id: $('#tg_id').val(),
            sexo: "X",
            show_checkboxes: true
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-clientes-disponibles').unblock();
            $('#tabla-resultados-clientes-disponibles').html(response);
            bind_pagination_links();

            $('#tabla-resultados-clientes-disponibles').find("input[name='select_all']").click(function() {
                if ($(this).is(':checked')) {
                    $('#tabla-resultados-clientes-disponibles').find("input[name='mover']").each(function() {
                        $(this).prop("checked", true);
                    });

                } else {
                    $('#tabla-resultados-clientes-disponibles').find("input[name='mover']").each(function() {
                        $(this).prop("checked", false);
                    });
                }
            });
        }
    });
}

function bind_pagination_links() {
    $('#tabla-resultados-clientes-tarifados').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultadosClientes();
    });
    $('#tabla-resultados-clientes-disponibles').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultadosClientesDisponibles();
    });
}


function get_clientes_disponibles_checkboxes() {
    var string = "";
    $('#tabla-resultados-clientes-disponibles').find('input[name="mover"]:checked').each(function() {
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

function get_clientes_tarifados_checkboxes() {
    var string = "";
    $('#tabla-resultados-clientes-tarifados').find('input[name="mover"]:checked').each(function() {
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

function bind_botones() {
    $('#btn-agregar').on('click', function(e) {
        e.preventDefault();
        if (get_clientes_disponibles_checkboxes()) {
            $.ajax({
                type: "POST",
                url: SITE_URL + 'panel_vendedor/tarifas/ajax_incluir_clientes',
                data: {
                    clientes_ids: get_clientes_disponibles_checkboxes(),
                    tarifa_general_id: $('#tg_id').val()
                },
                dataType: "json",
                success: function(response) {
                    $('#pagina').val("1");
                    updateResultadosClientes();
                    $('#pagina_tab2').val("1");
                    updateResultadosClientesDisponibles();
                }
            });

        }
    });

    $('#btn-remover').on('click', function(e) {
        e.preventDefault();
        if (get_clientes_tarifados_checkboxes()) {
            $.ajax({
                type: "POST",
                url: SITE_URL + 'panel_vendedor/tarifas/ajax_remover_clientes',
                data: {
                    clientes_ids: get_clientes_tarifados_checkboxes(),
                    tarifa_general_id: $('#tg_id').val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.success === "true") {
                        $('#pagina').val("1");
                        updateResultadosClientes();
                        $('#pagina_tab2').val("1");
                        updateResultadosClientesDisponibles();
                    } else {
                        alert(response.error);
                    }
                }
            });

        }
    });

}