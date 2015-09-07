$(document).ready(function() {
    updateResultados();

    $('#listado-productos').on('submit', function(e) {
        e.preventDefault();
        $('#pagina').val('1');
        updateResultados();
    });
});

function updateResultados() {
    var form = $('#listado-productos');
    $('#tabla-resultados').html('<br><br><br>');
    $('#tabla-resultados').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/producto/ajax_get_listado_resultados',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            bind_pagination_links();
            bind_links();
            bind_check_all();
            bind_btn_eliminar_seleccion();
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

function bind_links() {
    $('.table-responsive').find('.options').find('.row_action').off();
    $('.table-responsive').find('.options').find('.row_action').on('click', function(e) {
        e.preventDefault();
        var a_href = $(this).attr('href');
        $.blockUI({message: $('#question'), css: {}});

        if ($(this).hasClass('borrar')) {
            $('#question').find('.modal-title').html("Estas seguro que deseas eliminar este producto?.");
        } else if ($(this).hasClass('habilitar')) {
            $('#question').find('.modal-title').html("Estas seguro que deseas habilitar este producto?.");
        } else {
            $('#question').find('.modal-title').html("Estas seguro que deseas inhabilitar este producto?.");
        }

        $('#yes').off();
        $('#yes').click(function() {
            $.ajax({
                url: a_href,
                cache: false,
                complete: function() {
                    updateResultados();
                    $.unblockUI();
                }
            });
        });
        $('#no').click(function() {
            $.unblockUI();
            return false;
        });
    });

}

function bind_check_all() {
    $('#tabla-resultados').find("input[name='select_all']").click(function() {
        if ($(this).is(':checked')) {
            $('#tabla-resultados').find("input[name='eliminar']").each(function() {
                $(this).prop("checked", true);
            });

        } else {
            $('#tabla-resultados').find("input[name='eliminar']").each(function() {
                $(this).prop("checked", false);
            });
        }
    });
}

function bind_btn_eliminar_seleccion() {
    $('#btn-eliminar-seleccionados').on('click', function(e) {
        e.preventDefault();
        $.blockUI({message: $('#question'), css: {}});
        $('#question').find('.modal-title').html("Estas seguro que deseas eliminar estos productos?.");
        
        $('#yes').off();
        $('#yes').click(function() {
            $.ajax({
                url: SITE_URL+"panel_vendedor/producto/borrar-multi",                
                type:"POST",
                data:{
                    producto_ids:get_productos_seleccionados_checkboxes()
                },
                complete: function() {
                    updateResultados();
                    $.unblockUI();
                }
            });
        });
        $('#no').click(function() {
            $.unblockUI();
            return false;
        });

    });
}

function get_productos_seleccionados_checkboxes() {
    var string = "";
    $('#tabla-resultados').find('input[name="eliminar"]:checked').each(function() {
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