<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Invitacion_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "invitacion";
    }

    public function aceptar_invitacion($invitacion_id, $usuario_id) {
        $invitacion = $this->get($invitacion_id);
        if ($usuario_id == $invitacion->invitar_desde || $usuario_id == $invitacion->invitar_para) {
            $this->update($invitacion_id, array("estado" => "2"));
            return true;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $invitacion_id
     * @param type $usuario_id
     * @return boolean
     */
    public function rechazar_invitacion($invitacion_id, $usuario_id) {
        $invitacion = $this->get($invitacion_id);
        if ($usuario_id == $invitacion->invitar_desde || $usuario_id == $invitacion->invitar_para) {
            $this->update($invitacion_id, array("estado" => "3"));
            return true;
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
    public function find_mis_invitaciones($params, $limit, $offset, $order_by = "estado", $order = "asc") {
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM";
        $query.="(SELECT i.id,i.titulo,i.comentario,i.estado,i.invitar_desde,i.recibir_notificaciones,v.unique_slug,v.nombre,v.descripcion,'0' as enviado ";
        $query.="FROM invitacion i ";
        $query.="INNER JOIN usuario u ON u.id = i.invitar_desde AND i.invitar_para='" . $params["usuario_id"] . "' ";
        $query.="INNER JOIN cliente c ON c.usuario_id = u.id ";
        $query.="INNER JOIN vendedor v ON v.cliente_id = c.id ";
        $query.="WHERE (i.estado='1' OR i.estado='2')";

        $query.=" UNION ALL ";

        $query.="(SELECT i.id,i.titulo,i.comentario,i.estado,i.invitar_desde,i.recibir_notificaciones,v.unique_slug,v.nombre,v.descripcion,'1' as enviado ";
        $query.="FROM invitacion i ";
        $query.="INNER JOIN usuario u ON u.id = i.invitar_para AND i.invitar_desde='" . $params["usuario_id"] . "' ";
        $query.="INNER JOIN cliente c ON c.usuario_id = u.id ";
        $query.="INNER JOIN vendedor v ON v.cliente_id = c.id ";
        $query.="WHERE (i.estado='1' OR i.estado='2'))) temp";

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
    public function get_invitaciones_aceptadas($params, $limit, $offset, $order_by = "invitacion_id", $order = "desc") {
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM";
        $query.="(SELECT i.id as invitacion_id,c.id,c.nombres,c.apellidos,v.nombre as nombre_vendedor,u.fecha_creado,u.ultimo_acceso ";
        $query.="FROM invitacion i ";
        $query.="INNER JOIN usuario u ON u.id = i.invitar_desde AND i.invitar_para='" . $params["usuario_id"] . "' ";
        $query.="INNER JOIN cliente c ON c.usuario_id = u.id ";
        $query.="LEFT JOIN vendedor v ON v.cliente_id = c.id ";
        $query.="LEFT JOIN keyword k ON c.keyword=k.id ";
        $query.="WHERE ( 1";

        if (isset($params['nombre'])) {
            $text = " AND CONCAT(c.nombres,' ',c.apellidos) LIKE '%" . $params['nombre'] . "%'";
            $query.=$text;
        }

        if (isset($params['nombre_vendedor'])) {
            $text = " OR v.nombre LIKE '%" . $params['nombre_vendedor'] . "%'";
            $query.=$text;
        }

        $query.=") AND i.estado='2' ";

        if (isset($params['email'])) {
            $text = " AND u.email LIKE '%" . $params['email'] . "%'";
            $query.=$text;
        }

        if (isset($params['sexo'])) {
            $text = " AND c.sexo = '" . $params['sexo'] . "'";
            $query.=$text;
        }


        if (isset($params['usuario_activo'])) {
            $text = " AND u.activo = '" . $params["usuario_activo"] . "'";
            $query.=$text;
        }

        if (isset($params['keywords'])) {
            foreach ($params['keywords'] as $keyword) {
                $text = " AND k.keywords LIKE '%" . $keyword . "%'";
                $query.=$text;
            }
        }

        if (isset($params['excluir_admins'])) {
            $text = " AND ( u.permisos_id != '1' AND u.permisos_id != '2' )";
            $query.=$text;
        }


        if (isset($params['excluir_ids_clientes'])) {
            $ids = implode(",", $params['excluir_ids_clientes']);
            $query.=" AND c.id NOT IN(" . $ids . ")";
        }

        if (isset($params['incluir_ids_clientes'])) {
            $ids = implode(",", $params['incluir_ids_clientes']);
            $query.=" AND c.id IN(" . $ids . ")";
        }
        //$query.=" )";
        $query.=" UNION ALL ";

        $query.="SELECT i.id as invitacion_id,c.id,c.nombres,c.apellidos,v.nombre as nombre_vendedor,u.fecha_creado,u.ultimo_acceso ";
        $query.="FROM invitacion i ";
        $query.="INNER JOIN usuario u ON u.id = i.invitar_para AND i.invitar_desde='" . $params["usuario_id"] . "' ";
        $query.="INNER JOIN cliente c ON c.usuario_id = u.id ";
        $query.="LEFT JOIN vendedor v ON v.cliente_id = c.id ";
        $query.="LEFT JOIN keyword k ON c.keyword=k.id ";
        $query.="WHERE ( 1";

        if (isset($params['nombre'])) {
            $text = " AND CONCAT(c.nombres,' ',c.apellidos) LIKE '%" . $params['nombre'] . "%'";
            $query.=$text;
        }

        if (isset($params['nombre_vendedor'])) {
            $text = " OR v.nombre LIKE '%" . $params['nombre_vendedor'] . "%'";
            $query.=$text;
        }

        $query.=") AND i.estado='2' ";

        if (isset($params['email'])) {
            $text = " AND u.email LIKE '%" . $params['email'] . "%'";
            $query.=$text;
        }

        if (isset($params['sexo'])) {
            $text = " AND c.sexo = '" . $params['sexo'] . "'";
            $query.=$text;
        }


        if (isset($params['usuario_activo'])) {
            $text = " AND u.activo = '" . $params["usuario_activo"] . "'";
            $query.=$text;
        }

        if (isset($params['keywords'])) {
            foreach ($params['keywords'] as $keyword) {
                $text = " AND k.keywords LIKE '%" . $keyword . "%'";
                $query.=$text;
            }
        }

        if (isset($params['excluir_admins'])) {
            $text = " AND ( u.permisos_id != '1' AND u.permisos_id != '2' )";
            $query.=$text;
        }

        if (isset($params['excluir_ids_clientes'])) {
            $ids = implode(",", $params['excluir_ids_clientes']);
            $query.=" AND c.id NOT IN(" . $ids . ")";
        }
        if (isset($params['incluir_ids_clientes'])) {
            $ids = implode(",", $params['incluir_ids_clientes']);
            $query.=" AND c.id IN(" . $ids . ")";
        }

        //$query.=")";
        $query.=") temp";

        $query.=" ORDER BY " . $order_by . " " . $order;
        if ($limit) {
            $query.=" LIMIT " . $offset . " , " . $limit;
        }

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
    }

    /**
     * 
     * @return int
     */
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
    /**
     * usuario = usuario_id
     * estado = estado de la invitacion
     * 
     * @param type $params
     * @return type usuario_id de los invitados
     */
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

    /**
     * Si existe una invitacion no permitimos duplicados
     * @param type $persona
     * @param type $invitado
     * @return boolean
     */
    public function invitacion_existe($persona, $invitado) {
        $recibi_invitacion = $this->invitacion_model->get_many_by(array("invitar_desde" => $persona, "invitar_para" => $invitado));
        $envie_invitacion = $this->invitacion_model->get_many_by(array("invitar_para" => $persona, "invitar_desde" => $invitado));

        if ($recibi_invitacion || $envie_invitacion) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get_invitacion($persona, $invitado) {
        $recibi_invitacion = $this->invitacion_model->get_by(array("invitar_desde" => $persona, "invitar_para" => $invitado));
        $envie_invitacion = $this->invitacion_model->get_by(array("invitar_para" => $persona, "invitar_desde" => $invitado));

        if ($recibi_invitacion || $envie_invitacion) {
            if($recibi_invitacion){
                return $recibi_invitacion;
            }else{
                return $envie_invitacion;
            }                        
        } else {
            return false;
        }
    }

    /**
     * Invitaciones enviadas que todavia no han sido aceptadas
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function get_invitaciones_pendientes($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("cliente.*,invitacion.id as invitacion_id,usuario.email,usuario.ultimo_acceso,usuario.ip_address,usuario.fecha_creado,v2.nombre as nombre_vendedor");
        $this->db->from($this->_table);
        $this->db->join("usuario", "usuario.id=invitacion.invitar_para", 'INNER');
        $this->db->join("cliente", "cliente.usuario_id=usuario.id", 'INNER');
        $this->db->join("vendedor v2", "v2.cliente_id=cliente.id", 'LEFT');

        $this->db->where('invitacion.estado', '1');

        if (isset($params['nombre'])) {
            $this->db->like('CONCAT(cliente.nombres," ",cliente.apellidos)', $params['nombre'], 'both');
        }
        if (isset($params['nombre'])) {
            $this->db->where('cliente.sexo', $params['sexo']);
        }
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }

        /*if (isset($params['keywords'])) {
            foreach ($params['keywords'] as $keyword) {
                $this->db->like('cliente.keyword', $keyword, 'both');
            }
        }*/
        if (isset($params['invitar_desde'])) {
            $this->db->where('invitacion.invitar_desde', $params['invitar_desde']);
        }

        if (isset($params['excluir_admins'])) {
            $this->db->where('(usuario.permisos_id!="1" AND usuario.permisos_id!="2")');   // TODO: Hardcode Ids 
        }

        if (isset($params['usuario_activo'])) {
            $this->db->where("usuario.activo", $params['usuario_activo']);
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

    /**
     * 
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function get_invitaciones_recibidas($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("cliente.*,invitacion.id as invitacion_id,usuario.email,usuario.ultimo_acceso,usuario.ip_address,usuario.fecha_creado,v2.nombre as nombre_vendedor");
        $this->db->from($this->_table);
        $this->db->join("usuario", "usuario.id=invitacion.invitar_desde", 'INNER');
        $this->db->join("cliente", "cliente.usuario_id=usuario.id", 'INNER');
        $this->db->join("vendedor v2", "v2.cliente_id=cliente.id", 'LEFT');

        $this->db->where('invitacion.estado', "1");

        if (isset($params['nombre'])) {
            $this->db->like('CONCAT(cliente.nombres," ",cliente.apellidos)', $params['nombre'], 'both');
        }
        if (isset($params['sexo'])) {
            $this->db->where('cliente.sexo', $params['sexo']);
        }
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }

        /*if (isset($params['keywords'])) {
            foreach ($params['keywords'] as $keyword) {
                $this->db->like('cliente.keyword', $keyword, 'both');
            }
        }*/
        if (isset($params['invitar_para'])) {
            $this->db->where('invitacion.invitar_para', $params['invitar_para']);
        }

        if (isset($params['excluir_admins'])) {
            $this->db->where('(usuario.permisos_id!="1" AND usuario.permisos_id!="2")');   // TODO: Hardcode Ids 
        }

        if (isset($params['usuario_activo'])) {
            $this->db->where("usuario.activo", $params['usuario_activo']);
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

    public function son_contactos($persona, $invitado) {
        $recibi_invitacion = $this->invitacion_model->get_by(array("invitar_desde" => $persona, "invitar_para" => $invitado));
        $result = false;
        if ($recibi_invitacion) {
            if ($recibi_invitacion->estado == "2") {
                return true;
            }
        }

        $envie_invitacion = $this->invitacion_model->get_by(array("invitar_para" => $persona, "invitar_desde" => $invitado));
        if ($envie_invitacion) {
            if ($envie_invitacion->estado == "2") {
                return true;
            }
        }

        return $result;
    }

    /*
     * OJO el usuario_id del VENDEDOR
     */

    public function get_invitados_notificaciones($usuario_id) {
        $query = "SELECT i.invitar_para as usuario_id";
        $query.=" FROM invitacion as i";
        $query.=" WHERE invitar_desde='" . $usuario_id . "' and i.recibir_notificaciones='1'";
        $query.=" UNION";
        $query.=" SELECT i.invitar_desde as usuario_id";
        $query.=" FROM invitacion as i";
        $query.=" WHERE invitar_para='" . $usuario_id . "' and i.recibir_notificaciones='1'";

        $result = $this->db->query($query);
        $invitados = $result->result();

        if ($invitados) {
            $ids=array();
            foreach ($invitados as $inv) {
                $ids[] = $inv->usuario_id;
            }
            return $ids;
        } else {
            return false;
        }
    }

}
