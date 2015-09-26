$(document).ready(function() {

    $("#loginAuth").on('submit', function(e) {
        if ($('#loginAuth').valid()) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: SITE_URL + 'login',
                data: $("#loginAuth").serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success === "true") {
                        window.location.href = response.url;
                    } else {
                        $('#loginAuth').find('.alert-danger').removeClass('hidden');
                    }
                }
            });
        }

    });

    $("#loginAuth").validate({
        rules: {
            email: {required: true, email: true},
            password: {required: true}
        },
        messages: {
            email: {
                required: "El email es requerido.",
                email: "Email invalido."
            },
            password: {
                required: "Ingresa un password"
            }
        }
    });

});