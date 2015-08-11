$(document).ready(function() {
    $('.frame-ficha-thumbnail a').on('click', function(e) {
        e.preventDefault();        
        $('.frame-ficha img').attr('src',$(this).data('id'));        
    });            
    
    $('#sendInviteModal').on('shown.bs.modal', function(e) {
        var invoker = $(e.relatedTarget);        
        $('input[name="vendedor_id"]').val(invoker.data('id'));
    });
    
     $('#ofertaModal').on('hidden.bs.modal', function() {        
        $(this).removeData('bs.modal');        
    });
});
