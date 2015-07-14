<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Invitacion_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "invitacion";
    }

    public function get_invitaciones_pendientes($cliente_id) {
        $this->db->select("invitacion.id,invitacion.titulo,invitacion.comentario,vendedor.nombre,vendedor.descripcion");
        $this->db->from($this->_table);

        $this->db->join("vendedor", "vendedor.id=invitacion.vendedor_id", 'INNER');

        $this->db->where('invitacion.cliente_id', $cliente_id);
        $this->db->where('invitacion.from_vendedor', '1');
        $this->db->where('invitacion.estado', '1');

        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return false;
        }
    }

    public function aceptar_invitacion($invitacion_id, $cliente_id) {
        $invitacion = $this->get($invitacion_id);
        if ($cliente_id == $invitacion->cliente_id) {
            $this->update($invitacion_id, array("estado" => "2"));
            return true;
        } else {
            return false;
        }
    }

    public function rechazar_invitacion($invitacion_id, $cliente_id) {
        $invitacion = $this->get($invitacion_id);
        if ($cliente_id == $invitacion->cliente_id) {
            $this->update($invitacion_id, array("estado" => "3"));
            return true;
        } else {
            return false;
        }
    }

    public function get_site_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("invitacion.id,invitacion.titulo,invitacion.comentario,invitacion.estado,vendedor.unique_slug,vendedor.nombre,vendedor.descripcion");
        $this->db->from($this->_table);
        $this->db->join("cliente", "cliente.id=invitacion.cliente_id", 'INNER');

        $this->db->join("vendedor", "vendedor.id=invitacion.vendedor_id", 'INNER');

        if (isset($params['cliente_id'])) {
            $this->db->where('invitacion.cliente_id', $params['cliente_id']);
        }
        if (isset($params['from_vendedor'])) {
            $this->db->where('invitacion.from_vendedor', $params['from_vendedor']);
        }
        if (isset($params['estado'])) {
            $this->db->where('invitacion.estado', $params['estado']);
        }
        if (isset($params['or_estado'])) {
            $this->db->or_where('invitacion.estado', $params['or_estado']);
        }

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('invitacion.estado', 'asc');
            $this->db->limit($limit, $offset);
            $invitaciones = $this->db->get()->result();
            $this->db->flush_cache();
            return array("invitaciones" => $invitaciones, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("cliente.*,invitacion.id as invitacion_id,vendedor.id as vendedor_id,usuario.email,usuario.ultimo_acceso,usuario.ip_address,usuario.fecha_creado");
        $this->db->from($this->_table);
        $this->db->join("cliente", "cliente.id=invitacion.cliente_id", 'INNER');
        $this->db->join("usuario", "cliente.usuario_id=usuario.id", 'INNER');
        $this->db->join("vendedor", "vendedor.id=invitacion.vendedor_id", 'INNER');

        if (isset($params['nombre'])) {
            $this->db->like('CONCAT(cliente.nombres," ",cliente.apellidos)', $params['nombre'], 'both');
        }
        if (isset($params['sexo'])) {
            $this->db->where('cliente.sexo', $params['sexo']);
        }
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }

        if (isset($params['keywords'])) {
            foreach ($params['keywords'] as $keyword) {
                $this->db->like('cliente.keyword', $keyword, 'both');
            }
        }

        if (isset($params['vendedor_id'])) {
            $this->db->where('invitacion.vendedor_id', $params["vendedor_id"]);
        }
        if (isset($params['from_vendedor'])) {
            $this->db->where('invitacion.from_vendedor', $params['from_vendedor']);
        }
        if (isset($params['estado'])) {
            $this->db->where('invitacion.estado', $params['estado']);
        }
        if (isset($params['cliente_id'])) {
            $this->db->where('invitacion.cliente_id', $params['cliente_id']);
        }
        if (isset($params['excluir_admins'])) {
            $this->db->where('usuario.is_admin', "0");
        }
        if (isset($params['incluir_ids_clientes'])) {
            $this->db->where_in('invitacion.cliente_id', $params['incluir_ids_clientes']);
        }
        if (isset($params['excluir_ids_clientes'])) {
            $this->db->where_not_in('invitacion.cliente_id', $params['excluir_ids_clientes']);
        }

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('invitacion.id', 'desc');
            $this->db->limit($limit, $offset);
            $invitaciones = $this->db->get()->result();
            $this->db->flush_cache();
            return array("invitaciones" => $invitaciones, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    public function get_count_invitaciones() {
        if ($this->authentication->is_loggedin()) {
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            $this->db->select("COUNT(invitacion.id) as num");
            $this->db->from($this->_table);
            $this->db->join("vendedor", "vendedor.id=invitacion.vendedor_id", 'INNER');
            $this->db->where('invitacion.cliente_id', $cliente->id);
            $this->db->where('invitacion.from_vendedor', '1');
            $this->db->where('invitacion.estado', '1');

            $result = $this->db->get();

            if ($result->num_rows() > 0) {
                $res=$result->row();
                return $res->num;
            } else {
                return 0;
            }
        }else{
            return 0;
        }
    }

}
