$(document).ready(function() {
    $('#search_button').on('click', function(e) {
        e.preventDefault();

        var precio_desde = $('input[name="precio_desde"]').val();

        if (!$.isNumeric(precio_desde)) {
            if (precio_desde !== "") {
                $('input[name="precio_desde"]').val("");
                $('input[name="precio_desde"]').toggleClass("invalid-precio");
            }
            precio_desde = "";
        } else {
            $('input[name="precio_desde"]').removeClass("invalid-precio");
        }

        var precio_hasta = $('input[name="precio_hasta"]').val();

        if (!$.isNumeric(precio_hasta)) {
            if (precio_hasta !== "") {
                $('input[name="precio_hasta"]').val("");
                $('input[name="precio_hasta"]').toggleClass("invalid-precio");
            }
            precio_hasta = "";
        } else {
            $('input[name="precio_hasta"]').removeClass("invalid-precio");
        }

        $('#productos-buscar').submit(); 

    });

    $('.panel-blue').on('click', function() {
        window.location.href = SITE_URL + "site/como-funciona";
    });

    $('.panel-orange').on('click', function() {
        window.location.href = SITE_URL + "site/como-funciona";
    });

    $('.panel-green').on('click', function() {
        window.location.href = SITE_URL + "site/como-funciona";
    });

    $('.panel-gray').on('click', function() {
        window.location.href = SITE_URL + "site/como-funciona";
    });

    $('select[name="provincia"]').on('change', function() {
        $('select[name="poblacion"]').html("<option value='0'>Todas las Poblaciones</option>");
        var provincia_id = $(this).val();
        $.ajax({
            type: "POST",
            url: SITE_URL + 'util/get_poblaciones',
            data: {provincia_id: provincia_id},
            dataType: 'json',
            success: function(response) {
                $('select[name="poblacion"]').html(response.html);
                $('select[name="poblacion"]').find('option:first').text("Todas las Poblaciones");
            }
        });
    });
});