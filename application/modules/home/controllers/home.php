<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends MY_Controller {
    
    public function index(){
        $this->load->library('template');
        $this->template->set_title('Mercabarato - Anuncios y subastas');
        
        $this->template->load_view('home/index');
    }
}
    