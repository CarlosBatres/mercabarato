$(document).ready(function() {
    
    $("#admin_crear_form").find('input[name="vendedor"]').devbridgeAutocomplete({
        serviceUrl: SITE_URL + 'admin/vendedores/autocomplete',
        minChars: 1,
        onSelect: function(suggestion) {
            $('#vendedor_id').val(suggestion.data);
        },
        showNoSuggestionNotice: true,
        noSuggestionNotice: 'No se encontraron resultados',
    });         
});