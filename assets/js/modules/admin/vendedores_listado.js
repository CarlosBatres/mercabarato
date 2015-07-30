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
        url: SITE_URL + 'admin/vendedor/ajax_get_listado_resultados',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').unblock();
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
    $('.table-responsive').find('.options').find('.action').off();
    $('.table-responsive').find('.options').find('.action').on('click', function(e) {        
        e.preventDefault();        
        var a_href = $(this).attr('href');        
        $.blockUI({message: $('#question'), css: {}});
        
        if ($(this).hasClass('vendedor_borrar')) {
            $('#question').find('.modal-title').html("Eliminar Vendedor?.");
            $('#question').find('.modal-body').find('.content').html("Estas seguro que deseas Eliminar este vendedor? <br> Ten en cuenta que se eliminara todo lo asociado a el.");
        }else if($(this).hasClass('vendedor_inhabilitar')){
            $('#question').find('.modal-title').html("Inhabilitar al Vendedor?.");
            $('#question').find('.modal-body').find('.content').html("Estas seguro que deseas Inhabilitar a este vendedor? <br> Ten en cuenta que no podra acceder a su cuenta.");
        }else if($(this).hasClass('vendedor_habilitar')){
            $('#question').find('.modal-title').html("Habilitar al Vendedor?.");
            $('#question').find('.modal-body').find('.content').html("Estas seguro que deseas Habilitar a este vendedor?");
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