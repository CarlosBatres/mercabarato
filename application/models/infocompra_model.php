<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Infocompra_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "infocompra";
    }

    public function get_solicitudes_seguro($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("ss.*,cc.nombres,cc.apellidos,uc.email,m.enviado_por");
        $this->db->from("infocompra ss");
        $this->db->join("cliente cc", "cc.id=ss.cliente_id", 'INNER');
        $this->db->join("usuario uc", "uc.id=cc.usuario_id", 'INNER');
        $this->db->join("mensaje m", "m.infocompra_id=ss.id AND m.enviado_por='1'", 'LEFT');

        $this->db->where("ss.solicitud_seguro", "1");
        
        if (isset($params["vendedor_id"])) {
            $this->db->where("ss.vendedor_id", $params["vendedor_id"]);
        }

        if (isset($params["cliente_id"])) {
            $this->db->where("ss.cliente_id", $params["cliente_id"]);
        }

        if (isset($params["estado"])) {
            $this->db->where("ss.estado", $params["estado"]);
        }

        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('ss.estado asc,ss.fecha_solicitud desc');
            $this->db->limit($limit, $offset);
            $result = $this->db->get()->result();
            $this->db->flush_cache();
            return array("solicitud_seguros" => $result, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    public function get_solicitudes_seguro_cliente($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("infocompra.*,vendedor.nombre as nombre_vendedor,vendedor.unique_slug as vendedor_slug,vendedor.descripcion");
        $this->db->from("infocompra");
        $this->db->join("vendedor", "vendedor.id=infocompra.vendedor_id", 'INNER');
        $this->db->join("cliente", "cliente.id=vendedor.cliente_id", 'INNER');
        $this->db->join("usuario", "usuario.id=cliente.usuario_id", 'INNER');

        $this->db->where("infocompra.solicitud_seguro", "1");
        
        if (isset($params["vendedor_id"])) {
            $this->db->where("infocompra.vendedor_id", $params["vendedor_id"]);
        }

        if (isset($params["cliente_id"])) {
            $this->db->where("infocompra.cliente_id", $params["cliente_id"]);
        }

        if (isset($params["estado"])) {
            $this->db->where("infocompra.estado", $params["estado"]);
        }

        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('infocompra.estado desc,infocompra.fecha_solicitud desc');
            $this->db->limit($limit, $offset);
            $result = $this->db->get()->result();
            $this->db->flush_cache();
            return array("solicitud_seguros" => $result, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    public function cleanup_resources($infocompra_id) {
        $infocompra = $this->get($infocompra_id);
        unlink('./assets/' . $this->config->item('seguros_path') . '/' . $infocompra->link_file);        
    }

    public function delete($id) {
        $this->cleanup_resources($id);
        $this->mensaje_model->delete_by("infocompra_id", $id);
        parent::delete($id);
    }
    
    public function get_solicitudes_infocompras_cliente($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("infocompra.*,vendedor.nombre as nombre_vendedor,vendedor.unique_slug as vendedor_slug,vendedor.descripcion");
        $this->db->from("infocompra");
        $this->db->join("vendedor", "vendedor.id=infocompra.vendedor_id", 'INNER');
        $this->db->join("cliente", "cliente.id=vendedor.cliente_id", 'INNER');
        $this->db->join("usuario", "usuario.id=cliente.usuario_id", 'INNER');

        $this->db->where("infocompra.infocompra_general", "1");
        
        if (isset($params["vendedor_id"])) {
            $this->db->where("infocompra.vendedor_id", $params["vendedor_id"]);
        }

        if (isset($params["cliente_id"])) {
            $this->db->where("infocompra.cliente_id", $params["cliente_id"]);
        }

        if (isset($params["estado"])) {
            $this->db->where("infocompra.estado", $params["estado"]);
        }

        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('infocompra.estado desc,infocompra.fecha_solicitud desc');
            $this->db->limit($limit, $offset);
            $result = $this->db->get()->result();
            $this->db->flush_cache();
            return array("infocompras" => $result, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }
    
    public function get_solicitudes_infocompras($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("ss.*,cc.nombres,cc.apellidos,uc.email,m.enviado_por");
        $this->db->from("infocompra ss");
        $this->db->join("cliente cc", "cc.id=ss.cliente_id", 'INNER');
        $this->db->join("usuario uc", "uc.id=cc.usuario_id", 'INNER');
        $this->db->join("mensaje m", "m.infocompra_id=ss.id AND m.enviado_por='1'", 'LEFT');

        $this->db->where("ss.infocompra_general", "1");
        
        if (isset($params["vendedor_id"])) {
            $this->db->where("ss.vendedor_id", $params["vendedor_id"]);
        }

        if (isset($params["cliente_id"])) {
            $this->db->where("ss.cliente_id", $params["cliente_id"]);
        }

        if (isset($params["estado"])) {
            $this->db->where("ss.estado", $params["estado"]);
        }

        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('ss.estado asc,ss.fecha_solicitud desc');
            $this->db->limit($limit, $offset);
            $result = $this->db->get()->result();
            $this->db->flush_cache();
            return array("infocompras" => $result, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

}
