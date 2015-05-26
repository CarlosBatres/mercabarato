$(document).ready(function() {
    updateResultados();
    
    $('#listado-productos').on('submit',function(e){
        e.preventDefault();
        $('#pagina').val('1');
        updateResultados();        
    });
});

function updateResultados(){
    var form = $('#listado-productos');
    $.ajax({
        type: "POST",
        url: SITE_URL + 'admin/producto/ajax_get_listado_resultados',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-resultados').html(response);
            bind_pagination_links();
        }
    });
}

function bind_pagination_links(){
    $('.pagination a').on('click',function(e){
        e.preventDefault();
        $('#pagina').val($(this).data('id'));
        updateResultados();
    });
}