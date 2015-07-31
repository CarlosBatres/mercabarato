$(document).ready(function() {
    updateResultadosRequisitos();
    updateResultadosRequisitosDisponibles();
    bind_botones();
});

function updateResultadosRequisitos() {
    $('#tabla-resultados-requisitos-oferta').html('<br><br><br>');
    $('#tabla-resultados-requisitos-oferta').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/ofertas/ajax_get_requisitos',
        data: {
            pagina: $('#pagina').val(),
            oferta_general_id: $('#og_id').val(),
            show_checkboxes: true
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-requisitos-oferta').unblock();
            $('#tabla-resultados-requisitos-oferta').html(response);
            bind_pagination_links();

            $('#tabla-resultados-requisitos-oferta').find("input[name='select_all']").click(function() {
                if ($(this).is(':checked')) {
                    $('#tabla-resultados-requisitos-oferta').find("input[name='mover']").each(function() {
                        $(this).prop("checked", true);
                    });

                } else {
                    $('#tabla-resultados-requisitos-oferta').find("input[name='mover']").each(function() {
                        $(this).prop("checked", false);
                    });
                }
            });
        }
    });
}

function updateResultadosRequisitosDisponibles() {
    $('#tabla-resultados-requisitos-disponibles').html('<br><br><br>');
    $('#tabla-resultados-requisitos-disponibles').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/ofertas/ajax_get_requisitos_disponibles',
        data: {
            pagina: $('#pagina').val(),
            oferta_general_id: $('#og_id').val(),
            show_checkboxes: true
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-requisitos-disponibles').unblock();
            $('#tabla-resultados-requisitos-disponibles').html(response);
            bind_pagination_links();

            $('#tabla-resultados-requisitos-disponibles').find("input[name='select_all']").click(function() {
                if ($(this).is(':checked')) {
                    $('#tabla-resultados-requisitos-disponibles').find("input[name='mover']").each(function() {
                        $(this).prop("checked", true);
                    });

                } else {
                    $('#tabla-resultados-requisitos-disponibles').find("input[name='mover']").each(function() {
                        $(this).prop("checked", false);
                    });
                }
            });
        }
    });
}

function bind_pagination_links() {
    $('#tabla-resultados-requisitos-oferta').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultadosRequisitos();
    });
    $('#tabla-resultados-requisitos-disponibles').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultadosRequisitosDisponibles();
    });
}


function get_requisitos_disponibles_checkboxes() {
    var string = "";
    $('#tabla-resultados-requisitos-disponibles').find('input[name="mover"]:checked').each(function() {
        string += $(this).parents('tr').data('id');
        string += ";;";
    });
    if (string.length > 1) {
        string = string.slice(0, -2);
    }
    if (string.length === 0) {
        return false;
    } else {
        console.log(string);
        return string;
    }


}

function get_requisitos_checkboxes() {
    var string = "";
    $('#tabla-resultados-requisitos-oferta').find('input[name="mover"]:checked').each(function() {
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
        if (get_requisitos_disponibles_checkboxes()) {             
            $.ajax({
                type: "POST",
                url: SITE_URL + 'panel_vendedor/ofertas/ajax_incluir_requisitos',
                data: {
                    productos_ids: get_requisitos_disponibles_checkboxes(),
                    oferta_general_id: $('#og_id').val(),                    
                },
                dataType: "json",
                success: function(response) {                    
                    $('#pagina').val("1");
                    updateResultadosRequisitos();
                    $('#pagina_tab2').val("1");
                    updateResultadosRequisitosDisponibles();
                }
            });
        }
    });

    $('#btn-remover').on('click', function(e) {
        e.preventDefault();
        if (get_requisitos_checkboxes()) {
            $.ajax({
                type: "POST",
                url: SITE_URL + 'panel_vendedor/ofertas/ajax_remover_requisitos',
                data: {
                    productos_ids: get_requisitos_checkboxes(),
                    oferta_general_id: $('#og_id').val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.success === "true") {
                        $('#pagina').val("1");
                        updateResultadosRequisitos();
                        $('#pagina_tab2').val("1");
                        updateResultadosRequisitosDisponibles();
                    } else {
                        alert(response.error);
                    }

                }
            });

        }
    });


}