<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Usuario_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "usuario";
    }
    /**
     * 
     * @param type $email
     * @return boolean
     */
    public function email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('usuario');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    /**
     * 
     * @param type $usuario_id
     * @return boolean
     */
    public function get_full_identidad($usuario_id) {
        $identidad = array();
        $this->db->select("id,email,activo,fecha_creado,ultimo_acceso,ip_address,is_admin");
        $this->db->from("usuario");
        $this->db->where("id", $usuario_id);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $identidad['usuario'] = $result->row();
        } else {
            return false;
        }

        $this->db->select("*");
        $this->db->from("cliente");
        $this->db->where("usuario_id", $usuario_id);
        $result_cliente = $this->db->get();

        if ($result_cliente->num_rows() > 0) {
            $identidad['cliente'] = $result_cliente->row();

            $this->db->select("*");
            $this->db->from("vendedor");
            $this->db->where("cliente_id", $identidad['cliente']->id);
            $result_vendedor = $this->db->get();

            if ($result_vendedor->num_rows() > 0) {
                $identidad['vendedor'] = $result_vendedor->row();
            }
        }

        return $identidad;
    }
    /**
     * 
     * @param type $usuario_id
     * @return boolean
     */
    public function usuario_es_vendedor($usuario_id) {
        $user = $this->get_full_identidad($usuario_id);
        if ($user) {
            if (isset($user['vendedor'])) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * 
     * @param type $usuario_id
     * @return boolean
     */
    public function usuario_es_vendedor_habilitado($usuario_id){
        $user = $this->get_full_identidad($usuario_id);
        if ($user) {
            if (isset($user['vendedor'])) {
                if($user['vendedor']->habilitado==1){
                    return true;
                }else{
                    return false;
                }                
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
