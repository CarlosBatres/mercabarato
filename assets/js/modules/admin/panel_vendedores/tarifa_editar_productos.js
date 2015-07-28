$(document).ready(function() {
    updateResultadosProductos();
    updateResultadosProductosDisponibles();
    bind_botones();
});

function updateResultadosProductos() {
    $('#tabla-resultados-productos-tarifados').html('<br><br><br>');
    $('#tabla-resultados-productos-tarifados').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/tarifas/ajax_get_productos_tarifados',
        data: {
            pagina: $('#pagina').val(),
            tarifa_general_id: $('#tg_id').val(),
            show_checkboxes: true
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-productos-tarifados').unblock();
            $('#tabla-resultados-productos-tarifados').html(response);
            bind_pagination_links();

            $('#tabla-resultados-productos-tarifados').find("input[name='select_all']").click(function() {
                if ($(this).is(':checked')) {
                    $('#tabla-resultados-productos-tarifados').find("input[name='mover']").each(function() {
                        $(this).prop("checked", true);
                    });

                } else {
                    $('#tabla-resultados-productos-tarifados').find("input[name='mover']").each(function() {
                        $(this).prop("checked", false);
                    });
                }
            });
        }
    });
}

function updateResultadosProductosDisponibles() {
    $('#tabla-resultados-productos-disponibles').html('<br><br><br>');
    $('#tabla-resultados-productos-disponibles').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/tarifas/ajax_get_productos',
        data: {
            pagina: $('#pagina').val(),
            ignore_tarifa_general_id: $('#tg_id').val(),
            show_checkboxes: true
        },
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados-productos-disponibles').unblock();
            $('#tabla-resultados-productos-disponibles').html(response);
            bind_pagination_links();

            $('#tabla-resultados-productos-disponibles').find("input[name='select_all']").click(function() {
                if ($(this).is(':checked')) {
                    $('#tabla-resultados-productos-disponibles').find("input[name='mover']").each(function() {
                        $(this).prop("checked", true);
                    });

                } else {
                    $('#tabla-resultados-productos-disponibles').find("input[name='mover']").each(function() {
                        $(this).prop("checked", false);
                    });
                }
            });
        }
    });
}

function bind_pagination_links() {
    $('#tabla-resultados-productos-tarifados').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultadosProductos();
    });
    $('#tabla-resultados-productos-disponibles').find('.pagination a').on('click', function(e) {
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultadosProductosDisponibles();
    });
}


function get_productos_disponibles_checkboxes() {
    var string = "";
    $('#tabla-resultados-productos-disponibles').find('input[name="mover"]:checked').each(function() {
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

function get_productos_tarifados_checkboxes() {
    var string = "";
    $('#tabla-resultados-productos-tarifados').find('input[name="mover"]:checked').each(function() {
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
        if (get_productos_disponibles_checkboxes()) {
            $.ajax({
                type: "POST",
                url: SITE_URL + 'panel_vendedor/tarifas/ajax_modificar_costo_tarifa',
                data: {
                    productos_ids: get_productos_disponibles_checkboxes(),
                },
                dataType: "html",
                success: function(response) {
                    $('#myModal').find('.modal-content').html(response);
                    $('#myModal').modal();


                    $("#tarifas-modificar-monto").validate({
                        rules: {
                            nuevo_costo: {required: true, number: true},
                        },
                        messages: {
                            nuevo_costo: {required: "Este campo es necesario.", number: "Este campo tiene que ser un numero"},
                        }
                    });

                    $('#modificar-monto-submit').off().on('click', function(e) {
                        e.preventDefault();
                        if ($("#tarifas-modificar-monto").valid()) {
                            
                            var nuevos_costos = "";
                            $('#myModal').find('input[name="nuevo_costo"]').each(function() {
                                nuevos_costos += $(this).val();
                                nuevos_costos += ";;";
                            });
                            if (nuevos_costos.length > 1) {
                                nuevos_costos = nuevos_costos.slice(0, -2);
                            }

                            $.ajax({
                                type: "POST",
                                url: SITE_URL + 'panel_vendedor/tarifas/ajax_incluir_productos',
                                data: {
                                    productos_ids: get_productos_disponibles_checkboxes(),
                                    tarifa_general_id: $('#tg_id').val(),
                                    nuevos_costos: nuevos_costos
                                },
                                dataType: "json",
                                success: function(response) {
                                    $("#myModal").modal('hide');
                                    $('#pagina').val("1");
                                    updateResultadosProductos();
                                    $('#pagina_tab2').val("1");
                                    updateResultadosProductosDisponibles();
                                }
                            });
                        }
                    });
                }
            });
        }
    });

    $('#btn-remover').on('click', function(e) {
        e.preventDefault();
        if (get_productos_tarifados_checkboxes()) {
            $.ajax({
                type: "POST",
                url: SITE_URL + 'panel_vendedor/tarifas/ajax_remover_productos',
                data: {
                    productos_ids: get_productos_tarifados_checkboxes(),
                    tarifa_general_id: $('#tg_id').val()
                },
                dataType: "json",
                success: function(response) {
                    if (response.success === "true") {
                        $('#pagina').val("1");
                        updateResultadosProductos();
                        $('#pagina_tab2').val("1");
                        updateResultadosProductosDisponibles();
                    } else {
                        alert(response.error);
                    }

                }
            });

        }
    });
    
    $('#btn-modificar').on('click', function(e) {
        e.preventDefault();
        if (get_productos_tarifados_checkboxes()) {
            $.ajax({
                type: "POST",
                url: SITE_URL + 'panel_vendedor/tarifas/ajax_modificar_costo_tarifa',
                data: {
                    productos_ids: get_productos_tarifados_checkboxes(),
                },
                dataType: "html",
                success: function(response) {
                    $('#myModal').find('.modal-content').html(response);
                    $('#myModal').modal();


                    $("#tarifas-modificar-monto").validate({
                        rules: {
                            nuevo_costo: {required: true, number: true},
                        },
                        messages: {
                            nuevo_costo: {required: "Este campo es necesario.", number: "Este campo tiene que ser un numero"},
                        }
                    });

                    $('#modificar-monto-submit').off().on('click', function(e) {
                        e.preventDefault();
                        if ($("#tarifas-modificar-monto").valid()) {
                            
                            var nuevos_costos = "";
                            $('#myModal').find('input[name="nuevo_costo"]').each(function() {
                                nuevos_costos += $(this).val();
                                nuevos_costos += ";;";
                            });
                            if (nuevos_costos.length > 1) {
                                nuevos_costos = nuevos_costos.slice(0, -2);
                            }

                            $.ajax({
                                type: "POST",
                                url: SITE_URL + 'panel_vendedor/tarifas/ajax_modificar_productos',
                                data: {
                                    productos_ids: get_productos_tarifados_checkboxes(),
                                    tarifa_general_id: $('#tg_id').val(),
                                    nuevos_costos: nuevos_costos
                                },
                                dataType: "json",
                                success: function(response) {
                                    $("#myModal").modal('hide');
                                    $('#pagina').val("1");
                                    updateResultadosProductos();
                                    $('#pagina_tab2').val("1");
                                    updateResultadosProductosDisponibles();
                                }
                            });
                        }
                    });
                }
            });
        }
        
    });

}