<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends MY_Controller {

    public function index() {

        /* $this->template->set_title('Mercabarato - Anuncios y subastas');
          $productos = $this->producto_model->get_site_search(array(), 8, 0, "id", "DESC");
          $anuncios = $this->anuncio_model->get_ultimos_anuncios();
          if ($productos['total'] == 0) {
          $productos["productos"] = array();
          }
          $this->template->load_view('home/index', array(
          "productos" => $productos["productos"],
          "anuncios" => $anuncios)); */
    }

    public function not_found() {
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        $this->template->load_view('home/404');
    }

    public function acceso_invalido() {
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        $this->template->load_view('home/acceso_invalido');
    }

    public function verificar_palabra() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $word = $this->input->post('nombre');
                if (blacklisted_words($word)) {
                    echo json_encode(FALSE);
                } else {
                    echo json_encode(TRUE);
                }
            }
        } else {
            redirect('404');
        }
    }

}
