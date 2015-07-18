<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Permisos_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "permisos";
    }

    /**
     *  Asumimos que el permiso Default es el llamado Usuarios
     *  Si no existe lo creamos
     */
    public function get_permiso_default() {
        return $this->get_by("nombre", "Usuarios");
    }
    /**
     * 
     * @return type
     */
    public function get_permiso_vendedor_afiliado() {
        return $this->get_by("nombre", "Vendedores-Afiliados");
    }
    /**
     * 
     * @return type
     */
    public function get_permiso_admin_vendedor() {
        return $this->get_by("nombre", "Administrador-Vendedor");
    }
    
    
    
    /**
     * 
     * @param type $usuario_id
     */
    public function convertir_a_vendedor_admin($usuario_id){        
        $permiso=$this->get_permiso_admin_vendedor();        
        $this->usuario_model->update($usuario_id,array("permisos_id"=>$permiso->id));
    }
    /**
     * 
     * @param type $usuario_id
     */
    public function convertir_a_usuario($usuario_id){        
        $permiso=$this->get_permiso_default();        
        $this->usuario_model->update($usuario_id,array("permisos_id"=>$permiso->id));
    }
    /**
     * 
     * @param type $usuario_id
     * @return boolean
     */
    public function usuario_es_admin($usuario_id) {
        $usuario = $this->usuario_model->get($usuario_id);
        $permiso = $this->permisos_model->get($usuario->permisos_id);
        if ($permiso) {
            if ($permiso->nombre == "Administrador" || $permiso->nombre=="Administrador-Vendedor") {
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
    public function usuario_es_cliente($usuario_id){
        $usuario = $this->usuario_model->get($usuario_id);
        $permiso = $this->permisos_model->get($usuario->permisos_id);
        if ($permiso) {
            if ($permiso->nombre == "Usuarios") {
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
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @param type $order_by
     * @param type $order
     * @return type
     */
    public function buscar_clientes($params, $limit, $offset, $order_by = "cliente.id", $order = "asc") {
        $this->db->start_cache();

        $this->db->select("cliente.*,usuario.email,usuario.ultimo_acceso,usuario.ip_address,usuario.fecha_creado");
        $this->db->from("usuario");        
        $this->db->join("cliente", "cliente.usuario_id=usuario.id", 'INNER');       
        $this->db->join("permisos", "permisos.id=usuario.permisos_id", 'INNER');       

        if (isset($params['nombre'])) {
            $this->db->like('CONCAT(cliente.nombres," ",cliente.apellidos)', $params['nombre'], 'both');
        }        
        
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }
        
        $this->db->where('cliente.es_vendedor', "0");                
        
        $this->db->where("usuario.permisos_id !=","1");  // nunca incluyo al admin 
        
        if (isset($params['permisos_id'])) {
            $this->db->where('usuario.permisos_id', $params['permisos_id']);
        } 
        
        if (isset($params['usuario_activo'])) {
            $this->db->where('usuario.activo', $params['usuario_activo']);
        }        

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by($order_by, $order);
            $this->db->limit($limit, $offset);
            $clientes = $this->db->get()->result();
            $this->db->flush_cache();
            return array("clientes" => $clientes, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

}
