$(document).ready(function() {
    $('#form_crear').find('select[name="pais"]').on('change', function() {
        $('#form_crear').find('select[name="provincia"]').html("<option value='0'>Provincia</option>");
        $('#form_crear').find('select[name="poblacion"]').html("<option value='0'>Población</option>");
        var pais_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'util/get_provincias',
            data: {pais_id: pais_id},
            dataType: 'json',
            success: function(response) {
                $('#form_crear').find('select[name="provincia"]').html(response.html);
            }
        });
    });

    $('#form_crear').find('select[name="provincia"]').on('change', function() {
        $('#form_crear').find('select[name="poblacion"]').html("<option value='0'>Problación</option>");
        var provincia_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'util/get_poblaciones',
            data: {provincia_id: provincia_id},
            dataType: 'json',
            success: function(response) {
                $('#form_crear').find('select[name="poblacion"]').html(response.html);
            }
        });
    });
});