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
                Morris.Line({
                    element: 'morris_mensual',
                    data: data,
                    xkey: 'date',
                    ykeys: ['value'],
                    labels: ['Visitas'],
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
                Morris.Line({
                    element: 'morris_anual',
                    data: data,
                    xkey: 'month',
                    ykeys: ['value'],
                    labels: ['Visitas'],                    
                    xLabelFormat: function(x) {
                        return months[x.getMonth()];
                    },
                    yLabelFormat: function(y){return y !== Math.round(y)?'':y;}
                });
            }
        }
    });
}



