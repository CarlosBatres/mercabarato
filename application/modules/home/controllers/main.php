<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends MY_Controller {

    public function index() {                
        $this->template->set_title('Mercabarato - Anuncios y subastas');        
        $productos = $this->producto_model->get_site_search(array(), 8, 0 ,"id","DESC");        
        if($productos['total']==0){
            $productos["productos"]=array();
        }
        $this->template->load_view('home/index',array("productos"=>$productos["productos"]));
    }
    
    public function not_found(){
        $this->template->set_title('Mercabarato - Anuncios y subastas');        
        $this->template->load_view('home/404');
    }

}
