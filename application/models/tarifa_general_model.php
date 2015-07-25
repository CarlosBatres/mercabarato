<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tarifa_general_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "tarifa_general";
    }

    public function get_tarifas($params, $limit, $offset) {
        $query = "SELECT SQL_CALC_FOUND_ROWS t_p.id,t_p.nombre,t_p.descripcion,t_p.porcentaje,t_p.fecha_creado,productos,clientes ";
        $query.="FROM (";

        $query.="SELECT tg.*,COUNT(t.producto_id) as productos ";
        $query.="FROM (tarifa_general tg) ";
        $query.="INNER JOIN tarifa t ON t.tarifa_general_id = tg.id ";

        if (isset($params["vendedor_id"])) {
            $query.="INNER JOIN producto p ON p.id = t.producto_id ";
            $query.="WHERE p.vendedor_id = '" . $params["vendedor_id"] . "' ";
        }

        $query.="GROUP BY tg.id ) as t_p ";

        $query.="INNER JOIN ";

        $query.="(SELECT tg.*,COUNT(gt.cliente_id) as clientes ";
        $query.="FROM (tarifa_general tg) ";
        $query.="INNER JOIN grupo_tarifa gt ON gt.tarifa_general_id = tg.id ";
        $query.="GROUP BY tg.id ) as t_c ";
        $query.="ON t_p.id=t_c.id ";

        $query.=" LIMIT " . $offset . " , " . $limit;

        $result = $this->db->query($query);
        $results = $result->result();

        $query_total = "SELECT FOUND_ROWS() as rows;";
        $result_total = $this->db->query($query_total);
        $total = $result_total->row();

        if ($total->rows > 0) {
            return array("tarifas" => $results, "total" => $total->rows);
        } else {
            return array("total" => 0);
        }
    }

    public function get_vendedor_id_de_tarifa($tarifa_general_id) {
        $tarifa_general = $this->get($tarifa_general_id);
        if ($tarifa_general) {
            $tarifa = $this->tarifa_model->get_by("tarifa_general_id", $tarifa_general->id);
            if ($tarifa) {
                $producto = $this->producto_model->get($tarifa->producto_id);
                if ($producto) {
                    return $producto->vendedor_id;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return FALSE;
        }
    }

    public function delete($id) {
        $this->grupo_tarifa_model->delete_by("tarifa_general_id", $id);
        $this->tarifa_model->delete_by("tarifa_general_id", $id);
        parent::delete($id);
    }

}
