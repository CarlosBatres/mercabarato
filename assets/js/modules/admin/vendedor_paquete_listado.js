$(document).ready(function() {
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
        url: SITE_URL + 'admin/vendedor_paquete/ajax_get_listado_resultados',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').unblock();
            $('#tabla-resultados').html(response);
            bind_pagination_links();
            bind_aprobar_links();
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

function bind_aprobar_links() {
    $('.table-responsive').find('.options').find('.item_aprobar').off();
    $('.table-responsive').find('.options').find('.item_aprobar').on('click', function(e) {
        e.preventDefault();
        $.blockUI({message:"<h3>Espere un momento...<h3>"});
        
        var a_href = $(this).attr('href');
        var vendedor_paquete_id = $(this).data('id');
        $.ajax({
            type: "POST",
            url: SITE_URL + 'admin/vendedor_paquete/ajax_get_paquete_info',
            data: {
                vendedor_paquete_id: vendedor_paquete_id
            },
            dataType: "html",
            success: function(response) {
                $('#question').find('.question-content').html(response);
                $.unblockUI();
                $.blockUI({message: $('#question'), css: {}});
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
                $('#no').off();
                $('#no').click(function() {
                    $.unblockUI();
                    return false;
                });
            }
        });


    });
}