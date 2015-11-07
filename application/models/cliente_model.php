<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cliente_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "cliente";
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
    public function get_admin_search($params, $limit, $offset, $order_by = "cliente.id", $order = "DESC") {
        $this->db->start_cache();

        if (isset($params["join_vendedor"])) {
            $this->db->select("cliente.*,usuario.email,usuario.ultimo_acceso,usuario.ip_address,usuario.fecha_creado,usuario.activo,usuario.temporal,vendedor.nombre as nombre_vendedor");
            $this->db->from($this->_table);
            $this->db->join("usuario", "cliente.usuario_id=usuario.id", 'INNER');
            $this->db->join("vendedor", "vendedor.cliente_id=cliente.id", 'LEFT');
        } else {
            $this->db->select("cliente.*,usuario.email,usuario.ultimo_acceso,usuario.ip_address,usuario.fecha_creado,usuario.activo,usuario.temporal");
            $this->db->from($this->_table);
            $this->db->join("usuario", "cliente.usuario_id=usuario.id", 'INNER');
        }

        if (isset($params['nombre'])) {
            $this->db->like('CONCAT(cliente.nombres," ",cliente.apellidos)', $params['nombre'], 'both');
        }
        if (isset($params['nombre_vendedor'])) {
            $this->db->or_like('vendedor.nombre', $params['nombre_vendedor'], 'both');
        }
        if (isset($params['sexo'])) {
            $this->db->where('cliente.sexo', $params['sexo']);
        }
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }
        if (isset($params['es_vendedor'])) {
            $this->db->where('cliente.es_vendedor', $params["es_vendedor"]);
        }
        if (isset($params['excluir_admins'])) {
            $this->db->where('(usuario.permisos_id!="1" AND usuario.permisos_id!="2")');   // TODO: Hardcode Ids 
        }
        if (isset($params['usuario_activo'])) {
            $this->db->where('usuario.activo', $params['usuario_activo']);
        }

        if (isset($params['excluir_cliente_ids'])) {
            $this->db->where_not_in('cliente.id', $params['excluir_cliente_ids']);
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

    /**
     * 
     * @param type $cliente_id
     * @return boolean
     */
    public function es_vendedor($cliente_id) {
        $this->db->where('cliente_id', $cliente_id);
        $query = $this->db->get('vendedor');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param type $cliente_id
     * @return boolean
     */
    public function es_vendedor_habilitado($cliente_id) {
        if ($this->es_vendedor($cliente_id)) {
            $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente_id);
            if ($vendedor->habilitado == "1") {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /**
     * Full Delete de un producto
     * @param type $id
     */
    public function delete($id) {
        $cliente = $this->get($id);
        if ($cliente) {
            $usuario = $this->usuario_model->get($cliente->usuario_id);
            $this->localizacion_model->delete_by("usuario_id", $usuario->id);
            $this->invitacion_model->delete_by("invitar_para", $usuario->id);
            $this->invitacion_model->delete_by("invitar_desde", $usuario->id);

            $seguros = $this->infocompra_model->get_many_by("cliente_id", $id);
            if ($seguros) {
                foreach ($seguros as $seguro) {
                    $this->infocompra_model->delete($seguro->id);
                }
            }

            $this->visita_model->delete_by("cliente_id", $id);

            $this->grupo_tarifa_model->delete_by("cliente_id", $id);
            $this->grupo_oferta_model->delete_by("cliente_id", $id);

            $vendedor = $this->vendedor_model->get_by("cliente_id", $id);
            if ($vendedor) {
                $this->vendedor_model->delete($vendedor->id);
            }
            parent::delete($id);
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
    public function get_clientes_invitados($params, $limit, $offset, $order_by = "c.id", $order = "asc") {

        $query = "SELECT SQL_CALC_FOUND_ROWS c.*,u.email,u.ultimo_acceso,u.ip_address,u.fecha_creado,v.nombre as nombre_vendedor ";
        $query.="FROM cliente c ";
        $query.="INNER JOIN usuario u ON c.usuario_id = u.id ";
        $query.="LEFT JOIN vendedor v ON v.cliente_id = c.id ";
        $query.="LEFT JOIN keyword k ON c.keyword=k.id ";

        $query.="WHERE ( 1 ";

        if (isset($params['nombre'])) {
            $text = " AND CONCAT(c.nombres,' ',c.apellidos) LIKE '%" . $params['nombre'] . "%'";
            $query.=$text;
        }

        if (isset($params['nombre_vendedor'])) {
            $text = " OR v.nombre LIKE '%" . $params['nombre_vendedor'] . "%'";
            $query.=$text;
        }

        $query.=" ) AND ( 1";

        if (isset($params['email'])) {
            $text = " AND u.email LIKE '%" . $params['email'] . "%'";
            $query.=$text;
        }

        if (isset($params['es_vendedor'])) {
            $text = " AND c.es_vendedor = '" . $params['es_vendedor'] . "'";
            $query.=$text;
        }

        if (isset($params['excluir_admins'])) {
            $text = " AND (u.permisos_id != '1' AND u.permisos_id != '2')";
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

        $query.=" ) AND ( 1";

        if (isset($params['excluir_usuarios_ids'])) {
            $ex_ids = implode(",", $params["excluir_usuarios_ids"]);
            $text = " AND u.id NOT IN (" . $ex_ids . ")";
            $query.=$text;
        }


        $query.=") ";

        $query.=" ORDER BY " . $order_by . " " . $order;
        $query.=" LIMIT " . $offset . " , " . $limit;

        $result = $this->db->query($query);
        $clientes = $result->result();

        $query_total = "SELECT FOUND_ROWS() as rows;";
        $result_total = $this->db->query($query_total);
        $total = $result_total->row();

        if ($total->rows > 0) {
            return array("clientes" => $clientes, "total" => $total->rows);
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
    public function get_mensajes_search($params, $limit, $offset, $order_by = "cliente.id", $order = "asc") {
        $this->db->start_cache();
        $this->db->select("cliente.*,usuario.email,usuario.ultimo_acceso,usuario.ip_address,usuario.fecha_creado,usuario.activo");
        $this->db->from($this->_table);
        $this->db->join("usuario", "cliente.usuario_id=usuario.id", 'INNER');

        if (isset($params['nombre'])) {
            $this->db->like('CONCAT(cliente.nombres," ",cliente.apellidos)', $params['nombre'], 'both');
        }
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }
        if (isset($params['tipo_usuario'])) {
            if ($params['tipo_usuario'] == "1") {
                $this->db->where('cliente.es_vendedor', '0');
            } elseif ($params['tipo_usuario'] == "2") {
                $this->db->where('cliente.es_vendedor', '1');
            }
        }
        if (isset($params['ultimo_acceso'])) {
            if ($params['ultimo_acceso'] == "1") {
                $this->db->where('usuario.ultimo_acceso >=', 'date_add(now(), interval -1 month)', FALSE);
            } elseif ($params['ultimo_acceso'] == "2") {
                $this->db->where('usuario.ultimo_acceso >=', 'date_add(now(), interval -2 month)', FALSE);
            } elseif ($params['ultimo_acceso'] == "3") {
                $this->db->where('usuario.ultimo_acceso >=', 'date_add(now(), interval -5 month)', FALSE);
            } elseif ($params['ultimo_acceso'] == "4") {
                $this->db->where('usuario.ultimo_acceso <', 'date_add(now(), interval -12 month)', FALSE);
            }
        }
        if (isset($params['ignore_usuario_id'])) {
            $this->db->where_not_in('usuario.id', $params['ignore_usuario_id']);
        }

        if (isset($params['excluir_admins'])) {
            $this->db->where('(usuario.permisos_id!="1" AND usuario.permisos_id!="2")');   // TODO: Hardcode Ids 
        }
        if (isset($params['usuario_activo'])) {
            $this->db->where('usuario.activo', $params['usuario_activo']);
        }

        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            if (isset($params['ultimo_acceso'])) {
                $this->db->order_by("usuario.ultimo_acceso", "desc");
            } else {
                $this->db->order_by($order_by, $order);
            }

            if ($limit != -1 && $offset != -1) {
                $this->db->limit($limit, $offset);
            }

            $clientes = $this->db->get()->result();
            $this->db->flush_cache();
            return array("usuarios" => $clientes, "total" => $count);
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
     * @param type $order_by
     * @param type $order
     * @return type
     */
    public function get_estadisticas($params, $limit, $offset, $order_by = "c.id", $order = "ASC") {
        $vendedor = $params["vendedor_identidad"];
        $invitados_ids = $this->invitacion_model->get_ids_invitaciones(array("usuario" => $vendedor->usuario->id, "estado" => "2"));

        if (sizeof($invitados_ids) > 0) {

            $query = "SELECT SQL_CALC_FOUND_ROWS c.*,COUNT(v.id) as total,u.email,u.ultimo_acceso,u.ip_address,u.fecha_creado ";
            $query.="FROM cliente c ";
            $query.="INNER JOIN usuario u ON c.usuario_id = u.id ";
            $query.="INNER JOIN visita v ON c.id = v.cliente_id ";
            $query.="INNER JOIN producto p ON p.id = v.producto_id ";

            $query.="WHERE ( 1 ";

            $ids = implode(",", $invitados_ids);
            $text = " AND u.id IN (" . $ids . ")";
            $query.=$text;

            $query .=" AND v.fecha >='" . $params["date_from"] . "' ";
            $query .=" AND v.fecha <='" . $params["date_to"] . "' ";

            $query .=" AND p.vendedor_id ='" . $vendedor->get_vendedor_id() . "' ";

            $query.=") ";

            $query.=" GROUP BY c.id";

            $query.=" ORDER BY " . $order_by . " " . $order;
            $query.=" LIMIT " . $offset . " , " . $limit;

            $result = $this->db->query($query);
            $clientes = $result->result();

            $query_total = "SELECT FOUND_ROWS() as rows;";
            $result_total = $this->db->query($query_total);
            $total = $result_total->row();

            if ($total->rows > 0) {
                return array("clientes" => $clientes, "total" => $total->rows);
            } else {
                return array("total" => 0);
            }
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
    public function get_estadisticas_por_productos($params, $limit, $offset, $order_by = "v.fecha", $order = "DESC") {
        $vendedor = $params["vendedor_identidad"];

        $query = "SELECT SQL_CALC_FOUND_ROWS p.*,v.fecha as fecha_visita ";
        $query.="FROM producto p ";                
        $query.="INNER JOIN visita v ON v.producto_id = p.id ";        

        $query.="WHERE ( 1 ";        
        
        $query .=" AND p.vendedor_id ='" . $vendedor->get_vendedor_id() . "' ";

        if(isset($params["cliente_id"])){
            $query .=" AND v.cliente_id ='" . $params["cliente_id"]  . "'";
        }

        $query.=") ";        

        $query.=" ORDER BY " . $order_by . " " . $order;
        $query.=" LIMIT " . $offset . " , " . $limit;

        $result = $this->db->query($query);
        $productos = $result->result();

        $query_total = "SELECT FOUND_ROWS() as rows;";
        $result_total = $this->db->query($query_total);
        $total = $result_total->row();

        if ($total->rows > 0) {
            return array("productos" => $productos, "total" => $total->rows);
        } else {
            return array("total" => 0);
        }
    }
    /**
     * 
     * @param type $cliente_id
     * @return boolean
     */
    public function get_email($cliente_id) {
        $cliente=$this->get($cliente_id);
        if($cliente){
            return $this->usuario_model->get_email($cliente->usuario_id);            
        }else{
            return false;
        }
    }

}
