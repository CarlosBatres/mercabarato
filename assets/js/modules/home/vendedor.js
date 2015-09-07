$(document).ready(function() {               
    $('#sendInviteModal').on('shown.bs.modal', function(e) {
        var invoker = $(e.relatedTarget);        
        $('input[name="vendedor_id"]').val(invoker.data('id'));
    });
    
    $('#enviar-solicitud-seguros').on('click',function(e){
        e.preventDefault();
        $('.formularios-seguros').css('display','block');
    });
});
