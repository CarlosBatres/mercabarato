<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Producto extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function view_listado(){
        //$this->show_profiler();
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        //$this->template->add_js('producto.js');
        
        $productos=$this->producto_model->get_site_search("",0,0);
        $this->template->load_view('home/producto/listado',array("productos"=>$productos["productos"]));
    }
            
}