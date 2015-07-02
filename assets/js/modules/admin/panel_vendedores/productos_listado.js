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
        }else if($(this).hasClass('habilitar')){
            $('#question').find('.modal-title').html("Estas seguro que deseas habilitar este producto?.");
        }else{
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