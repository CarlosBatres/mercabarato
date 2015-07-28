<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sistema extends MY_Controller {

    public function __construct() {
        parent::__construct();    
    }
    
    /**
     *  Verifico los paquetes que estan por caducar y los inhabilito (vendedor/productos/anuncios)
     */
    public function validar_paquetes(){
        $paquetes_vencidos=$this->vendedor_paquete_model->get_paquetes_a_caducar();
        if($paquetes_vencidos){
            foreach($paquetes_vencidos as $paquete){
                $this->vendedor_paquete_model->paquete_vencido($paquete->id);                                
            }
        }        
    }
    
    public function productos_novedades(){
        $productos=$this->producto_model->get_novedades_fecha("2015-07-1","2015-07-28");                
    }
}