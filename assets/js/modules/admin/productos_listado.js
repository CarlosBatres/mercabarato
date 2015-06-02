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
    $('#tabla-resultados').html('');
    $.ajax({
        type: "POST",
        url: SITE_URL + 'admin/producto/ajax_get_listado_resultados',
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
    $('.table-responsive').find('.options').find('.producto_borrar').off('click').on('click', function(e) {
        console.log("bind_borrar_links");
        e.preventDefault();
        var a_href = $(this).attr('href');
        $.blockUI({message: $('#question'), css: {}});

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