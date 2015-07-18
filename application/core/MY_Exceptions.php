<?php
// application/core/MY_Exceptions.php
class MY_Exceptions extends CI_Exceptions {

    public function show_404()
    {
        redirect("pagina-no-existe");
    }
}