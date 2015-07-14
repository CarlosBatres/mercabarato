<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Localizacion_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "localizacion";
    }       
         
    
    public function get_full_localizacion($id){
        $localizacion=$this->get($id);
        if($localizacion){
            if($localizacion->pais_id!=null){
                $pais=$this->pais_model->get($localizacion->pais_id);
            }else{
                $pais=null;
            }            
            
            if($localizacion->provincia_id!=null){
                $provincia=$this->provincia_model->get($localizacion->provincia_id);
            }else{
                $provincia=null;
            }            
            
            if($localizacion->poblacion_id!=null){
                $poblacion=$this->poblacion_model->get($localizacion->poblacion_id);
            }else{
                $poblacion=null;
            }   
            $local=array();
            $local["pais"]=$pais;
            $local["provincia"]=$provincia;
            $local["poblacion"]=$poblacion;
            
            return $local;            
        }else{
            return false;
        }
    }
}
