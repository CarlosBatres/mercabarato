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
    public function email_exists($email, $ignore_temporal = false) {
        $this->db->where('email', $email);
        if ($ignore_temporal) {
            $this->db->where('temporal', '0');
        }
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
        $identidad_obj = new Identidad();

        $this->db->select("id,email,activo,fecha_creado,ultimo_acceso,ip_address,permisos_id");
        $this->db->from("usuario");
        $this->db->where("id", $usuario_id);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            $identidad_obj->usuario = $result->row();
        } else {
            return false;
        }

        $this->db->select("*");
        $this->db->from("cliente");
        $this->db->where("usuario_id", $usuario_id);
        $result_cliente = $this->db->get();

        if ($result_cliente->num_rows() > 0) {
            $identidad_obj->cliente = $result_cliente->row();

            $this->db->select("*");
            $this->db->from("vendedor");
            $this->db->where("cliente_id", $identidad_obj->get_cliente_id());
            $result_vendedor = $this->db->get();

            if ($result_vendedor->num_rows() > 0) {
                $identidad_obj->vendedor = $result_vendedor->row();
            }
        }

        return $identidad_obj;
    }

    /**
     * 
     * @param type $usuario_id
     * @return boolean
     */
    public function usuario_es_vendedor($usuario_id) {
        $user = $this->get_full_identidad($usuario_id);
        if ($user) {
            return $user->es_vendedor();
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $usuario_id
     * @return boolean
     */
    public function usuario_es_vendedor_habilitado($usuario_id) {
        $user = $this->get_full_identidad($usuario_id);
        if ($user) {
            return $user->es_vendedor_habilitado();
        } else {
            return false;
        }
    }

    public function verificar_email($secret_key) {
        $this->usuario_model->update_by(array("secret_key" => $secret_key), array("activo" => "1", "secret_key" => null));
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function inhabilitar($usuario_id) {
        $usuario = $this->get($usuario_id);
        if ($usuario) {
            $this->update($usuario_id, array("activo" => "0"));
        }
    }

    public function habilitar($usuario_id) {
        $usuario = $this->get($usuario_id);
        if ($usuario) {
            $this->update($usuario_id, array("activo" => "1"));
        }
    }

    public function get_email($usuario_id) {
        $this->db->select("usuario.email");
        $this->db->from($this->_table);
        $this->db->where("usuario.id", $usuario_id);

        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->row()->email;
        } else {
            return FALSE;
        }
    }

    public function delete($id) {
        $usuario = $this->get($id);
        if ($usuario) {
            $this->localizacion_model->delete_by("usuario_id", $usuario->id);
            $this->restriccion_model->delete_by("usuario_id", $usuario->id);
            parent::delete($id);
        } else {
            return false;
        }
    }

}

class Identidad {

    public $cliente;
    public $usuario;
    public $vendedor;

    function __construct() {
        $this->cliente = null;
        $this->usuario = null;
        $this->vendedor = null;
    }

    /**
     * 
     * @return boolean
     */
    public function get_cliente_id() {
        if ($this->cliente != null) {
            return $this->cliente->id;
        } else {
            return false;
        }
    }

    /**
     * 
     * @return boolean
     */
    public function get_vendedor_id() {
        if ($this->vendedor != null) {
            return $this->vendedor->id;
        } else {
            return false;
        }
    }

    /**
     * 
     * @return boolean
     */
    public function es_vendedor() {
        if ($this->vendedor != null && $this->cliente->es_vendedor == "1") {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @return boolean
     */
    public function es_vendedor_habilitado() {
        if ($this->vendedor != null) {
            if ($this->vendedor->habilitado == 1) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
