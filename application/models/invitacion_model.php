<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Invitacion_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "invitacion";
    }

    /* public function get_invitaciones_pendientes($cliente_id) {
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
      } */

    public function aceptar_invitacion($invitacion_id, $usuario_id) {
        $invitacion = $this->get($invitacion_id);
        if ($usuario_id == $invitacion->invitar_desde || $usuario_id == $invitacion->invitar_para) {
            $this->update($invitacion_id, array("estado" => "2"));
            return true;
        } else {
            return false;
        }
    }

    public function rechazar_invitacion($invitacion_id, $usuario_id) {
        $invitacion = $this->get($invitacion_id);
        if ($usuario_id == $invitacion->invitar_desde || $usuario_id == $invitacion->invitar_para) {
            $this->update($invitacion_id, array("estado" => "3"));
            return true;
        } else {
            return false;
        }
    }

    public function find_mis_invitaciones($params, $limit, $offset,$order_by="i.estado",$order="asc") {
        $query = "SELECT SQL_CALC_FOUND_ROWS i.id,i.titulo,i.comentario,i.estado,v.unique_slug,v.nombre,v.descripcion ";
        $query.="FROM invitacion i ";
        $query.="INNER JOIN usuario u ON u.id = i.invitar_desde AND i.invitar_para='".$params["usuario_id"]."' "; 
        $query.="INNER JOIN cliente c ON c.usuario_id = u.id ";
        $query.="LEFT JOIN vendedor v ON v.cliente_id = c.id ";

        $query.="WHERE (i.estado='1' OR i.estado='2')";

        $query.=" ORDER BY " . $order_by . " " . $order;
        $query.=" LIMIT " . $offset . " , " . $limit;

        $result = $this->db->query($query);
        $invitaciones = $result->result();

        $query_total = "SELECT FOUND_ROWS() as rows;";
        $result_total = $this->db->query($query_total);
        $total = $result_total->row();

        if ($total->rows > 0) {
            return array("invitaciones" => $invitaciones, "total" => $total->rows);
        } else {
            return array("total" => 0);
        }










        /*$this->db->start_cache();
        $this->db->select("invitacion.id,invitacion.titulo,invitacion.comentario,invitacion.estado,vendedor.unique_slug,vendedor.nombre,vendedor.descripcion");
        $this->db->from($this->_table);
        $this->db->join("usuario", "invitacion.invitar_desde=usuario.id OR invitacion.invitar_para=usuario.id", 'INNER');
        $this->db->join("cliente", "cliente.usuario_id=usuario.id", 'INNER');
        $this->db->join("vendedor", "vendedor.cliente_id=cliente.id", 'LEFT');

        if (isset($params['usuario_id'])) {
            $this->db->where('(invitacion.invitar_desde="' . $params['usuario_id'] . '" OR invitacion.invitar_para="' . $params['usuario_id'] . '")');
        }

        if (isset($params['estado'])) {
            $this->db->where('invitacion.estado', $params['estado']);
        }
        if (isset($params['or_estado'])) {
            $this->db->or_where('invitacion.estado', $params['or_estado']);
        }
        $this->db->group_by("invitacion.id");
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
        }*/
    }

    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();

        if (isset($params["invitaciones_pendientes"])) {
            $this->db->select("cliente.*,invitacion.id as invitacion_id,usuario.email,usuario.ultimo_acceso,usuario.ip_address,usuario.fecha_creado,v2.nombre as nombre_vendedor");
            $this->db->from($this->_table);
            $this->db->join("usuario", "usuario.id=invitacion.invitar_para", 'INNER');
            $this->db->join("cliente", "cliente.usuario_id=usuario.id", 'INNER');
            $this->db->join("vendedor v2", "v2.cliente_id=cliente.id", 'LEFT');
        } else if (isset($params["invitaciones_recibidas"])) {
            $this->db->select("cliente.*,invitacion.id as invitacion_id,usuario.email,usuario.ultimo_acceso,usuario.ip_address,usuario.fecha_creado,v2.nombre as nombre_vendedor");
            $this->db->from($this->_table);
            $this->db->join("usuario", "usuario.id=invitacion.invitar_desde", 'INNER');
            $this->db->join("cliente", "cliente.usuario_id=usuario.id", 'INNER');
            $this->db->join("vendedor v2", "v2.cliente_id=cliente.id", 'LEFT');
        } else {
            $this->db->select("cliente.*,invitacion.id as invitacion_id,vendedor.id as vendedor_id,usuario.email,usuario.ultimo_acceso,usuario.ip_address,usuario.fecha_creado,v2.nombre as nombre_vendedor");
            $this->db->from($this->_table);
            $this->db->join("cliente", "cliente.id=invitacion.cliente_id", 'INNER');
            $this->db->join("usuario", "cliente.usuario_id=usuario.id", 'INNER');
            $this->db->join("vendedor v2", "v2.cliente_id=cliente.id", 'LEFT');
        }



        if (isset($params['nombre'])) {
            $this->db->like('CONCAT(cliente.nombres," ",cliente.apellidos)', $params['nombre'], 'both');
        }
        if ($params['sexo'] != '0') {
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
        if (isset($params['invitar_desde'])) {
            $this->db->where('invitacion.invitar_desde', $params['invitar_desde']);
        }
        if (isset($params['invitar_para'])) {
            $this->db->where('invitacion.invitar_para', $params['invitar_para']);
        }

        if (isset($params['estado'])) {
            $this->db->where('invitacion.estado', $params['estado']);
        }
        if (isset($params['excluir_admins'])) {
            $this->db->where('usuario.is_admin', "0");
        }

        /* if (isset($params['incluir_ids_clientes'])) {
          $this->db->where_in('invitacion.cliente_id', $params['incluir_ids_clientes']);
          }
          if (isset($params['excluir_ids_clientes'])) {
          $this->db->where_not_in('invitacion.cliente_id', $params['excluir_ids_clientes']);
          } */

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

    public function count_invitaciones_pendientes() {
        if ($this->authentication->is_loggedin()) {
            $user_id = $this->authentication->read('identifier');

            $this->db->select("COUNT(invitacion.id) as num");
            $this->db->from($this->_table);
            $this->db->where('invitacion.estado', '1');
            $this->db->where('(invitacion.invitar_para="' . $user_id . '")');


            $result = $this->db->get();

            if ($result->num_rows() > 0) {
                $res = $result->row();
                return $res->num;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function get_ids_invitaciones($params) {
        $ids = array();

        $invitar_desde = $this->invitacion_model->get_many_by(array("invitar_desde" => $params["usuario"], "estado" => $params["estado"]));
        if ($invitar_desde) {
            foreach ($invitar_desde as $inv) {
                $ids[] = $inv->invitar_para;
            }
        }
        $invitar_para = $this->invitacion_model->get_many_by(array("invitar_para" => $params["usuario"], "estado" => $params["estado"]));
        if ($invitar_para) {
            foreach ($invitar_para as $inv) {
                $ids[] = $inv->invitar_desde;
            }
        }
        return $ids;
    }

    public function invitacion_existe($persona, $invitado) {
        $recibi_invitacion = $this->invitacion_model->get_many_by(array("invitar_desde" => $persona, "invitar_para" => $invitado));
        $envie_invitacion = $this->invitacion_model->get_many_by(array("invitar_para" => $persona, "invitar_desde" => $invitado));

        if ($recibi_invitacion || $envie_invitacion) {
            return true;
        } else {
            return false;
        }
    }

}
