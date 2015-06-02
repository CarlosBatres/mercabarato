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
    $('#tabla-resultados').html('');
    $.ajax({
        type: "POST",
        url: SITE_URL + 'admin/comprador/ajax_get_listado_resultados',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').html(response);
            bind_pagination_links();
            bind_borrar_links();
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

function bind_borrar_links() {
    $('.table-responsive').find('.options').find('.comprador_borrar').off();
    $('.table-responsive').find('.options').find('.comprador_borrar').on('click', function(e) {        
        e.preventDefault();        
        var a_href = $(this).attr('href');        
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
        $('#no').click(function() {
            $.unblockUI();
            return false;
        });
    });
}