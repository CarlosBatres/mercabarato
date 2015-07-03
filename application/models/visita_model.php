<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Visita_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "visita";
    }

    /**
     * 
     * @param type $producto_id
     * @param type $vista_producto
     */
    public function nueva_visita_producto($producto_id) {
        $user_id = $this->authentication->read('identifier');
        if ($user_id) {
            $usuario = $this->usuario_model->get_full_identidad($user_id);
            $ip_address = $this->session->userdata('ip_address');
            if (!$usuario->es_vendedor()) {
                $visita = $this->get_by(array(
                    "fecha" => date("Y-m-d"),
                    "producto_id" => $producto_id,
                    "cliente_id" => $usuario->get_cliente_id(),
                    "vista_producto" => "1"));

                if (!$visita) {
                    $data = array(
                        "producto_id" => $producto_id,
                        "cliente_id" => $usuario->get_cliente_id(),
                        "vista_anuncio" => "0",
                        "vista_producto" => "1",
                        "ip_address" => $ip_address,
                        "fecha" => date("Y-m-d")
                    );
                    $this->insert($data);
                }
            }
        }
    }

    /**
     * Por año o por mes
     * 
     * @param type $fecha_inicio
     * @param type $fecha_fin
     * @param type $vendedor_id
     * @param type $por_año
     */
    public function generar_estadisticas_visitas($fecha_inicio, $fecha_fin, $vendedor_id, $por_año) {
        $visitas = $this->get_vendedors_visitas_durante($fecha_inicio, $fecha_fin, $vendedor_id, $por_año);
        $data = array();
        if ($visitas) {
            if ($por_año == false) {
                $month = $visitas[0]->month;
                $year = $visitas[0]->year;
                $count = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                for ($index = 1; $index <= $count; $index++) {
                    $flag = true;
                    foreach ($visitas as $visita) {
                        if ($visita->day == $index) {
                            $data[] = array("date" => $visita->fecha, "value" => $visita->total);
                            $flag = false;
                        }
                    }
                    if ($flag) {
                        $data[] = array("date" => date("Y-m-d", strtotime($year . "-" . $month . "-" . $index)), "value" => 0);
                    }
                }
            } else {
                $year = $visitas[0]->year;
                $count = 12;

                for ($index = 1; $index <= $count; $index++) {
                    $flag = true;
                    foreach ($visitas as $visita) {
                        if ($visita->month == $index) {                            
                            $data[] = array("month" => $visita->year . '-' . $visita->month, "value" => $visita->total);
                            $flag = false;
                        }
                    }
                    if ($flag) {
                        $data[] = array("month" => date("Y-m-d", strtotime($year . "-" . $index)), "value" => 0);
                    }
                }
            }
            return $data;
        } else {
            return false;
        }
    }

    /**
     * 
     */
    public function get_vendedors_visitas_durante($fecha_inicio, $fecha_fin, $vendedor_id, $group_by_month = false) {
        $this->db->select("visita.id,visita.fecha, COUNT(visita.id) as total,EXTRACT( YEAR FROM visita.fecha) as year,EXTRACT( MONTH FROM visita.fecha) as month,EXTRACT( DAY FROM visita.fecha) as day");
        $this->db->from("visita");
        $this->db->join("producto", "producto.id=visita.producto_id", 'INNER');
        $this->db->where('visita.fecha >=', $fecha_inicio);
        $this->db->where('visita.fecha <=', $fecha_fin);
        $this->db->where('visita.vista_producto', "1");
        $this->db->where('producto.vendedor_id', $vendedor_id);

        if ($group_by_month) {
            $this->db->group_by('Month(visita.fecha)');
        } else {
            $this->db->group_by('visita.fecha');
        }


        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return FALSE;
        }
    }

}
