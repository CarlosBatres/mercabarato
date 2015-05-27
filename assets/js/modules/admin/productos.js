$(document).ready(function() {
    
    // admin/producto/nuevo
    $("#admin_nuevo_producto").find('input[name="vendedor"]').devbridgeAutocomplete({
        serviceUrl: SITE_URL + 'admin/vendedores/autocomplete',
        minChars: 1,
        onSelect: function(suggestion) {
            $('#vendedor_id').val(suggestion.data);
        },
        showNoSuggestionNotice: true,
        noSuggestionNotice: 'No se encontraron resultados',
    });
    
    // admin/producto/editar
    $("#admin_editar_producto").find('input[name="vendedor"]').devbridgeAutocomplete({
        serviceUrl: SITE_URL + 'admin/vendedores/autocomplete',
        minChars: 1,
        onSelect: function(suggestion) {
            $('#vendedor_id').val(suggestion.data);
        },
        showNoSuggestionNotice: true,
        noSuggestionNotice: 'No se encontraron resultados',
    });
});