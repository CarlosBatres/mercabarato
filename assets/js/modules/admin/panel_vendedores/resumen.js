$(document).ready(function() {
    //getVisitasDataMensual();

    getVisitasDataAnual();
    getVisitasDataAnualAfiliados();
    updateResultados();
});

function getVisitasDataMensual() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: SITE_URL + 'panel_vendedor/visitas/get_estadisticas',
        data: {tipo: "mensual"},
        success: function(data) {
            if (data === "empty") {
                $('#morris_general').html("No se encontraron resultados..");
            } else {
                Morris.Line({
                    element: 'morris_general',
                    data: data,
                    xkey: 'date',
                    ykeys: ['producto', 'anuncio'],
                    labels: ['Productos Visitados', 'Anuncios Visitados'],
                    yLabelFormat: function(y) {
                        return y !== Math.round(y) ? '' : y;
                    }
                });
            }

        }
    });
}

function getVisitasDataAnual() {
    var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $('#morris_general').html('<br><br><br>');
    $('#morris_general').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: SITE_URL + 'panel_vendedor/visitas/get_estadisticas',
        data: {tipo: "anual"},
        success: function(data) {
            $('#morris_general').unblock();
            $('#morris_general').html('');
            if (data === "empty") {
                $('#morris_general').html('<div class="alert alert-warning"><p> De momento tus productos no tienen visitas.</p></div> ');
            } else {
                Morris.Line({
                    element: 'morris_general',
                    data: data,
                    xkey: 'month',
                    ykeys: ['producto', 'anuncio'],
                    labels: ['Productos Visitados', 'Anuncios Visitados'],
                    xLabelFormat: function(x) {
                        return months[x.getMonth()];
                    },
                    yLabelFormat: function(y) {
                        return y !== Math.round(y) ? '' : y;
                    }
                });
            }
        }
    });
}

function getVisitasDataAnualAfiliados() {
    var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $('#morris_general_afiliados').html('<br><br><br>');
    $('#morris_general_afiliados').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: SITE_URL + 'panel_vendedor/visitas/get_estadisticas_afiliados',
        data: {tipo: "anual"},
        success: function(data) {
            $('#morris_general_afiliados').unblock();
            $('#morris_general_afiliados').html('');
            if (data === "empty") {
                $('#morris_general_afiliados').html('<div class="alert alert-warning"><p> De momento ninguno de tus afiliados a visitado tus productos.</p></div> ');
            } else {
                Morris.Line({
                    element: 'morris_general_afiliados',
                    data: data,
                    xkey: 'month',
                    ykeys: ['producto', 'anuncio'],
                    labels: ['Productos Visitados', 'Anuncios Visitados'],
                    lineColors: ['#f60303', '#e0db56'],
                    xLabelFormat: function(x) {
                        return months[x.getMonth()];
                    },
                    yLabelFormat: function(y) {
                        return y !== Math.round(y) ? '' : y;
                    }
                });
            }
        }
    });
}

function updateResultados() {
    var form = $('#listado-productos');
    $('#tabla-productos').html('<br><br><br>');
    $('#tabla-productos').block({
        message: '<h4>Procesando espere un momento..</h4>',
        css: {border: '3px solid #a00'}
    });
    $.ajax({
        type: "POST",
        url: SITE_URL + 'panel_vendedor/visitas/get_productos_visitas',
        data: form.serialize(),
        dataType: "html",
        success: function(response) {
            $('#tabla-productos').unblock();
            $('#tabla-productos').html(response);
            bind_pagination_links();
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