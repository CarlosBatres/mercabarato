$(document).ready(function() {
    $('.frame-ficha-thumbnail a').on('click', function(e) {
        e.preventDefault();        
        $('.frame-ficha img').attr('src',$(this).data('id'));        
    });
});
