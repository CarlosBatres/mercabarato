<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Anuncio extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function ver_anuncio($id) {
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        $anuncio = $this->anuncio_model->get($id);
        if ($anuncio) {
            if ($this->authentication->is_loggedin()) {
                $this->visita_model->nueva_visita_anuncio($anuncio->id);
                $user_id = $this->authentication->read('identifier');
                $cliente = $this->cliente_model->get_by("usuario_id", $user_id);


                $params = array(
                    "vendedor_id" => $anuncio->vendedor_id,
                    "cliente_id" => $cliente->id
                );
                $otros_productos = $this->producto_model->get_site_search($params, 4, 0, "p.id", "desc");
                if ($otros_productos["total"] > 0) {
                    $prods = $otros_productos["productos"];
                } else {
                    $prods = false;
                }


                $data = array(
                    "anuncio" => $anuncio,
                    "otros_productos" => $prods);
                $this->template->load_view('home/anuncio/ficha', $data);
            } else {                
                $params = array(
                    "vendedor_id" => $anuncio->vendedor_id,
                );
                $otros_productos = $this->producto_model->get_site_search($params, 4, 0, "p.id", "desc");
                if ($otros_productos["total"] > 0) {
                    $prods = $otros_productos["productos"];
                } else {
                    $prods = false;
                }
                
                $data = array(
                    "anuncio" => $anuncio,                                        
                    "otros_productos" => $prods);
                $this->template->load_view('home/anuncio/ficha', $data);
            }
        } else {
            show_404();
        }
    }

}
