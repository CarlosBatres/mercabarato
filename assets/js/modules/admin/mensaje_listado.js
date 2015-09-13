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
        url: SITE_URL + 'admin/mensajes/ajax_get_listado_resultados',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            bind_pagination_links();
            bind_links();
            bind_select_all();
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
    $('.table-responsive').find('.options').find('.btn-enviar').off();
    $('.table-responsive').find('.options').find('.btn-enviar').on('click', function(e) {
        e.preventDefault();
        var a_href = $(this).attr('href');
        var usuario_id = $(this).parents('tr').data('id');
        $.blockUI({message: $('#question'),blockMsgClass: 'modal-confimacion'});

        $('#yes').off();
        $('#yes').click(function() {
            $.ajax({
                url: a_href,
                cache: false,
                type: 'POST',
                data: {usuario_ids: usuario_id},
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
    
    $('#btn-enviar-seleccionados').off();
    $('#btn-enviar-seleccionados').on('click', function(e) {
        e.preventDefault();        
        var usuario_id = get_selected_checkboxes();
        $.blockUI({message: $('#question'),blockMsgClass: 'modal-confimacion'});

        $('#yes').off();
        $('#yes').click(function() {
            $.ajax({
                url: SITE_URL+'admin/mensajes/enviar-mensaje',
                cache: false,
                type: 'POST',
                data: {usuario_ids: usuario_id},
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
    
    $('#btn-enviar-todos').off();
    $('#btn-enviar-todos').on('click', function(e) {
        e.preventDefault();                
        $.blockUI({message: $('#question'),blockMsgClass: 'modal-confimacion'});

        $('#yes').off();
        $('#yes').click(function() {
            $.ajax({
                url: SITE_URL+'admin/mensajes/enviar-mensaje',
                cache: false,
                type: 'POST',
                data: {enviar_todos: "true"},
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

function bind_select_all() {
    $('#tabla-resultados').find("input[name='select_all']").click(function() {
        if ($(this).is(':checked')) {
            $('#tabla-resultados').find("input[name='enviar']").each(function() {
                $(this).prop("checked", true);
            });

        } else {
            $('#tabla-resultados').find("input[name='enviar']").each(function() {
                $(this).prop("checked", false);
            });
        }
    });
}

function get_selected_checkboxes() {
    var string = "";
    $('#tabla-resultados').find('input[name="enviar"]:checked').each(function() {
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