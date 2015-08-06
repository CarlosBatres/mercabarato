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
                    $this->producto_model->verificar_oferta($producto_id);
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
        $visitas = $this->get_vendedors_visitas_durante($fecha_inicio, $fecha_fin, $vendedor_id, 1, $por_año);
        $visitas_anuncios = $this->get_vendedors_visitas_durante($fecha_inicio, $fecha_fin, $vendedor_id, 0, $por_año);
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
                            $data[] = array("date" => $visita->fecha, "producto" => $visita->total, "anuncio" => 0);
                            $flag = false;
                        }
                    }
                    if ($flag) {
                        $data[] = array("date" => date("Y-m-d", strtotime($year . "-" . $month . "-" . $index)), "producto" => 0, "anuncio" => 0);
                    }
                }

                if ($visitas_anuncios) {
                    for ($index = 1; $index <= $count; $index++) {
                        $flag = true;
                        foreach ($visitas_anuncios as $visita) {
                            if ($visita->day == $index) {
                                $data[$index - 1]['anuncio'] = $visita->total;
                                $flag = false;
                            }
                        }
                        if ($flag) {
                            $data[$index - 1]['anuncio'] = 0;
                        }
                    }
                }
            } else {
                $year = $visitas[0]->year;
                $count = 12;

                for ($index = 1; $index <= $count; $index++) {
                    $flag = true;
                    foreach ($visitas as $visita) {
                        if ($visita->month == $index) {
                            $data[] = array("month" => $visita->year . '-' . $visita->month, "producto" => $visita->total, "anuncio" => 0);
                            $flag = false;
                        }
                    }
                    if ($flag) {
                        $data[] = array("month" => date("Y-m-d", strtotime($year . "-" . $index)), "producto" => 0, "anuncio" => 0);
                    }
                }

                if ($visitas_anuncios) {
                    for ($index = 1; $index <= $count; $index++) {
                        $flag = true;
                        foreach ($visitas_anuncios as $visita) {
                            if ($visita->month == $index) {
                                $data[$index - 1]['anuncio'] = $visita->total;
                                $flag = false;
                            }
                        }
                        if ($flag) {
                            $data[$index - 1]['anuncio'] = 0;
                        }
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
    public function get_vendedors_visitas_durante($fecha_inicio, $fecha_fin, $vendedor_id, $tipo, $group_by_month = false) {
        $this->db->select("visita.id,visita.fecha, COUNT(visita.id) as total,EXTRACT( YEAR FROM visita.fecha) as year,EXTRACT( MONTH FROM visita.fecha) as month,EXTRACT( DAY FROM visita.fecha) as day");
        $this->db->from("visita");
        if ($tipo === 1) {
            $this->db->join("producto", "producto.id=visita.producto_id AND producto.vendedor_id=" . $vendedor_id, 'INNER');
            $this->db->where('visita.vista_producto', "1");
        } else {
            $this->db->join("anuncio", "anuncio.id=visita.anuncio_id AND anuncio.vendedor_id=" . $vendedor_id, 'INNER');
            $this->db->where('visita.vista_anuncio', "1");
        }

        $this->db->where('visita.fecha >=', $fecha_inicio);
        $this->db->where('visita.fecha <=', $fecha_fin);
        //$this->db->where('producto.vendedor_id', $vendedor_id);

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

    public function nueva_visita_anuncio($anuncio_id) {
        $user_id = $this->authentication->read('identifier');
        if ($user_id) {
            $usuario = $this->usuario_model->get_full_identidad($user_id);
            $ip_address = $this->session->userdata('ip_address');
            if (!$usuario->es_vendedor()) {
                $visita = $this->get_by(array(
                    "fecha" => date("Y-m-d"),
                    "anuncio_id" => $anuncio_id,
                    "cliente_id" => $usuario->get_cliente_id(),
                    "vista_anuncio" => "1"));

                if (!$visita) {
                    $data = array(
                        "anuncio_id" => $anuncio_id,
                        "cliente_id" => $usuario->get_cliente_id(),
                        "vista_anuncio" => "1",
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
     * Busqueda que une Visitantes y No visitantes
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @param type $order_by
     * @param type $order
     * @return type
     */
    public function get_visitantes($params, $limit, $offset, $order_by = "visitas", $order = "desc") {
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM ";
        $query.="(SELECT COUNT(vi.cliente_id) as visitas,c.id,c.nombres,c.apellidos,v.nombre as nombre_vendedor,u.fecha_creado,u.ultimo_acceso ";
        $query.="FROM visita vi ";
        $query.="INNER JOIN cliente c ON vi.cliente_id=c.id ";
        $query.="INNER JOIN usuario u ON u.id=c.usuario_id ";
        $query.="LEFT JOIN vendedor v ON v.cliente_id = c.id ";
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

        if (isset($params['sexo'])) {
            $text = " AND c.sexo = '" . $params['sexo'] . "'";
            $query.=$text;
        }

        if (isset($params['keywords'])) {
            foreach ($params['keywords'] as $keyword) {
                $text = " AND c.keyword LIKE '%" . $keyword . "%'";
                $query.=$text;
            }
        }

        if (isset($params['visitas_producto_id'])) {
            $text = " AND vi.producto_id IN(" . implode(",", $params['visitas_producto_id']) . ")";
            $query.=$text;
        }

        if (isset($params['ignore_cliente_id'])) {
            $text = " AND c.id!='" . $params['ignore_cliente_id'] . "'";
            $query.=$text;
        }

        if (isset($params['usuario_activo'])) {
            $text = " AND u.activo = '" . $params["usuario_activo"] . "'";
            $query.=$text;
        }

        if (isset($params['excluir_admins'])) {
            $text = " AND (u.permisos_id != '1' AND u.permisos_id != '2')";
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
        $query.=")";
        $query.=" GROUP BY vi.cliente_id";

        $query.=" UNION ALL ";

        $query.="SELECT '0',c.id,c.nombres,c.apellidos,v.nombre as nombre_vendedor,u.fecha_creado,u.ultimo_acceso ";
        $query.="FROM cliente c ";
        $query.="INNER JOIN usuario u ON u.id=c.usuario_id ";
        $query.="LEFT JOIN vendedor v ON v.cliente_id = c.id ";
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

        if (isset($params['sexo'])) {
            $text = " AND c.sexo = '" . $params['sexo'] . "'";
            $query.=$text;
        }

        if (isset($params['keywords'])) {
            foreach ($params['keywords'] as $keyword) {
                $text = " AND c.keyword LIKE '%" . $keyword . "%'";
                $query.=$text;
            }
        }

        if (isset($params['ignore_cliente_id'])) {
            $text = " AND c.id!='" . $params['ignore_cliente_id'] . "'";
            $query.=$text;
        }

        if (isset($params['usuario_activo'])) {
            $text = " AND u.activo = '" . $params["usuario_activo"] . "'";
            $query.=$text;
        }

        if (isset($params['excluir_admins'])) {
            $text = " AND (u.permisos_id != '1' AND u.permisos_id != '2')";
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

        if (isset($params['es_vendedor'])) {
            $text = " AND c.es_vendedor = '" . $params["es_vendedor"] . "'";
            $query.=$text;
        }

        $query.=")) temp";

        $query.=" GROUP BY id";
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

}
