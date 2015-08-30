$(document).ready(function() {
    $('#search_button').on('click', function() {
        window.location.href = SITE_URL + "ir_productos/" + $("input[name='search_query']").val();
    });
    
    $('.panel-blue').on('click', function() {
        window.location.href = SITE_URL + "site/busca-y-compara";
    });
    
    $('.panel-orange').on('click', function() {
        window.location.href = SITE_URL + "site/infocompras";
    });
    
    $('.panel-green').on('click', function() {
        window.location.href = SITE_URL + "site/tarifas-personales";
    });
    
    $('.panel-gray').on('click', function() {
        window.location.href = SITE_URL + "site/ventajas-vendedor";
    });        
});