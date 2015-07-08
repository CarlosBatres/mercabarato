$(document).ready(function() {
    getVisitasDataMensual();
    getVisitasDataAnual();

});

function getVisitasDataMensual() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: SITE_URL + 'panel_vendedor/visitas/get_estadisticas',
        data: {tipo: "mensual"},
        success: function(data) {
            if (data === "empty") {
                $('#morris_mensual').html("No se encontraron resultados..");
            } else {
                Morris.Area({
                    element: 'morris_mensual',
                    data: data,
                    xkey: 'date',
                    ykeys: ['producto','anuncio'],
                    labels: ['Productos Visitados','Anuncios Visitados'],
                    yLabelFormat: function(y){return y !== Math.round(y)?'':y;}
                });
            }

        }
    });
}

function getVisitasDataAnual() {
    var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: SITE_URL + 'panel_vendedor/visitas/get_estadisticas',
        data: {tipo: "anual"},
        success: function(data) {
            if (data === "empty") {
                $('#morris_anual').html("No se encontraron resultados..");
            } else {
                Morris.Area({
                    element: 'morris_anual',
                    data: data,
                    xkey: 'month',
                    ykeys: ['producto','anuncio'],
                    labels: ['Productos Visitados','Anuncios Visitados'],                    
                    xLabelFormat: function(x) {
                        return months[x.getMonth()];
                    },
                    yLabelFormat: function(y){return y !== Math.round(y)?'':y;}
                });
            }
        }
    });
}



