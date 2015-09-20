<?php
// application/core/MY_Exceptions.php
class MY_Exceptions extends CI_Exceptions {

    public function show_404($page = '', $log_error = TRUE)
    {
        redirect("pagina-no-existe");
    }
}