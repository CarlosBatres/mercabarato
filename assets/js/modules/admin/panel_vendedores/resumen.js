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
            Morris.Line({                
                element: 'morris_mensual',                
                data: data,                
                xkey: 'date',                
                ykeys: ['value'],                
                labels: ['Visitas']
            });
        }
    });
}

function getVisitasDataAnual() {
    $.ajax({
        type: "POST",
        dataType: 'json',
        url: SITE_URL + 'panel_vendedor/visitas/get_estadisticas',
        data: {tipo: "anual"},
        success: function(data) {
            Morris.Line({                
                element: 'morris_anual',                
                data: data,                
                xkey: 'date',                
                ykeys: ['value'],                
                labels: ['Visitas']
            });
        }
    });
}



