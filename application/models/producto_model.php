<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Producto_model extends MY_Model {

    public $has_many = array('producto_resources' => array('model' => 'producto_resource_model', 'primary_key' => 'producto_id'));
    public $before_create = array('pre_insertado');

    function __construct() {
        parent::__construct();
        $this->_table = "producto";
    }

    /**
     * 
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("producto.*,categoria.nombre AS Categoria,vendedor.nombre AS Vendedor");
        $this->db->from($this->_table);
        $this->db->join("categoria", "categoria.id=producto.categoria_id", 'INNER');
        $this->db->join("vendedor", "vendedor.id=producto.vendedor_id", 'INNER');
        $this->db->join("vendedor_paquete", "vendedor.id=vendedor_paquete.vendedor_id AND vendedor_paquete.aprobado='1' AND"
                . " vendedor_paquete.fecha_terminar >='" . date("Y-m-d") . "' AND vendedor_paquete.fecha_inicio <='" . date("Y-m-d") . "'", 'LEFT');
        $this->db->join("productos_localizacion", "productos_localizacion.producto_id=producto.id", 'INNER');

        if (isset($params['nombre'])) {
            $this->db->like('producto.nombre', $params['nombre'], 'both');
        }
        if (isset($params['categoria_id'])) {
            $this->db->where('producto.categoria_id', $params['categoria_id']);
        }
        if (isset($params['vendedor'])) {
            $this->db->like('vendedor.nombre', $params['vendedor'], 'both');
        }
        if (isset($params['vendedor_id'])) {
            $this->db->where('vendedor.id', $params['vendedor_id']);
        }
        if (isset($params['autorizado_por'])) {
            $this->db->where('vendedor_paquete.autorizado_por', $params['autorizado_por']);
        }

        if (isset($params['pais_id'])) {
            $this->db->where('productos_localizacion.pais_id', $params['pais_id']);
        }
        if (isset($params['provincia_id'])) {
            $this->db->where('productos_localizacion.provincia_id', $params['provincia_id']);
        }
        if (isset($params['poblacion_id'])) {
            $this->db->where('productos_localizacion.poblacion_id', $params['poblacion_id']);
        }


        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('id', 'asc');
            $this->db->limit($limit, $offset);
            $productos = $this->db->get()->result();
            $this->db->flush_cache();
            return array("productos" => $productos, "total" => $count);
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
    public function get_site_search($params, $limit, $offset, $order_by, $order) {
        if (isset($params['no_result'])) {
            return array("total" => 0);
        }
        if (isset($params['cliente_id'])) {
            $usuario_tmp=$this->cliente_model->get($params["cliente_id"]);
            /*             * -------------------------------------------------------------------------
             * 
             * Busqueda cuando se haya iniciado session, se hace en base a un cliente_id
             *
             * ------------------------------------------------------------------------- 
             */

            $query = "SELECT SQL_CALC_FOUND_ROWS p.*, pr.filename as imagen_nombre,vd.filename as imagen_vendedor, "
                    . "CASE WHEN inv1.id IS NOT NULL THEN true WHEN inv2.id IS NOT NULL THEN true ELSE false END AS invitacion, ";

            if (isset($params["order_by_grupo_txt"])) {
                $familia = (isset($params["order_by_familia_txt"]) ? $params["order_by_familia_txt"] : '');
                $subfamilia = (isset($params["order_by_subfamilia_txt"]) ? $params["order_by_subfamilia_txt"] : '');
                $query.="(MATCH (grupo_txt) AGAINST ('" . $params["order_by_grupo_txt"] . "' IN BOOLEAN MODE) * 3 + ";
                $query.="MATCH (familia_txt) AGAINST ('" . $familia . "' IN BOOLEAN MODE) * 2 + ";
                $query.="MATCH (subfamilia_txt) AGAINST ('" . $subfamilia . "' IN BOOLEAN MODE) ";
                $query.=") as relevance ";
            } else {
                $query.=" '0' as relevance ";
            }

            $query.= "FROM (SELECT * FROM  `productos_precios` ORDER BY nuevo_costo ASC ) as p ";
            $query.="LEFT JOIN producto_resource pr ON pr.producto_id = p.id AND pr.tipo='imagen_principal' ";
            $query.="INNER JOIN vendedor vd ON vd.id = p.vendedor_id ";
            $query.="INNER JOIN cliente c ON c.id=vd.cliente_id ";
            $query.="INNER JOIN productos_localizacion pl ON pl.producto_id = p.id ";

            $query.="LEFT JOIN ( SELECT * FROM invitacion i WHERE i.invitar_desde='$usuario_tmp->usuario_id' AND i.estado='2' ) as inv1 ON inv1.invitar_para=c.usuario_id ";
            $query.="LEFT JOIN ( SELECT * FROM invitacion i WHERE i.invitar_para='$usuario_tmp->usuario_id' AND i.estado='2' ) as inv2 ON inv2.invitar_desde=c.usuario_id ";

            // SUB QUERY //

            $sub_query = "";
            if (isset($params['search_query'])) {
                $text = " AND (p.nombre LIKE '%" . $params['search_query'] . "%' OR p.descripcion LIKE '%" . $params['search_query'] . "%' ) ";
                $sub_query.=$text;
            }
            if (isset($params['nombre'])) {
                $text = " AND p.nombre LIKE '%" . $params['nombre'] . "%'";
                $sub_query.=$text;
            }
            if (isset($params['descripcion'])) {
                $text = " AND p.descripcion LIKE '%" . $params['descripcion'] . "%'";
                $sub_query.=$text;
            }
            if (isset($params['categoria_id'])) {
                //$arriba = $this->get_categorias_arbol($params['categoria_id']);
                $arriba[] = $params['categoria_id'];
                $abajo = $this->get_all_categorias_of($params['categoria_id']);
                if ($abajo) {
                    $categorias_array = array_merge($arriba, $abajo);
                } else {
                    $categorias_array = $arriba;
                }

                $text = " AND p.categoria_id IN(" . implode(",", $categorias_array) . ")";
                $sub_query.=$text;
            }

            if (isset($params['precio_desde'])) {
                $text = " AND p.precio >= '" . $params['precio_desde'] . "' ";
                $query.=$text;
                $sub_query.=$text;
            }
            if (isset($params['precio_hasta'])) {
                $text = " AND p.precio <= '" . $params['precio_hasta'] . "' ";
                $query.=$text;
                $sub_query.=$text;
            }

            if (isset($params["poblacion"])) {
                if ($params['poblacion'] != '0') {
                    $text = " AND pl.poblacion_id='" . $params['poblacion'] . "' ";
                    $sub_query.=$text;
                }
            }
            if (isset($params["provincia"])) {
                if ($params['provincia'] != '0') {
                    $text = " AND pl.provincia_id='" . $params['provincia'] . "' ";
                    $sub_query.=$text;
                }
            }
            if (isset($params["pais"])) {
                if ($params['pais'] != '0') {
                    $text = " AND pl.pais_id='" . $params['pais'] . "' ";
                    $sub_query.=$text;
                }
            }
            if (isset($params["vendedor_id"])) {
                $text = " AND p.vendedor_id='" . $params['vendedor_id'] . "' ";
                $sub_query.=$text;
            }
            if (isset($params['excluir_producto_id'])) {
                $ids = implode(",", $params['excluir_producto_id']);
                $text = " AND p.id NOT IN(" . $ids . ") ";
                $sub_query.=$text;
            }
            if (isset($params['excluir_vendedor_id'])) {
                $text = " AND p.vendedor_id!='" . $params['excluir_vendedor_id'] . "' ";
                $sub_query.=$text;
            }
            if (isset($params['mostrar_solo_tarifas'])) {
                $text = " AND p.tipo='tarifa' ";
                $sub_query.=$text;
            }

            if (isset($params['solo_vendedor_ids'])) {
                $ids = implode(",", $params['solo_vendedor_ids']);
                $text = " AND p.vendedor_id IN(" . $ids . ") ";
                $sub_query.=$text;
            }

            if (isset($params["habilitado"])) {
                $text = " AND p.habilitado=" . $params['habilitado'];
                $sub_query.=$text;
            }

            $sub_query.=" ) ";

            // SUB QUERY //


            $query.="WHERE ( p.cliente_id ='" . $params['cliente_id'] . "' AND p.tipo='tarifa' " . $sub_query;
            $query.= " OR ( (p.cliente_id ='" . $params['cliente_id'] . "' OR p.cliente_id IS NULL ) " .
                    "AND p.fecha_finaliza >= '" . date("Y-m-d") . "' AND p.fecha_inicio <= '" . date("Y-m-d") . "'  AND p.tipo='oferta' " . $sub_query;
            $query.= " OR ( p.tipo='normal' " . $sub_query;

            if (isset($params["habilitado"])) {
                $query.=" AND p.habilitado=" . $params['habilitado'];
            }

            $query.=" GROUP BY p.id";
            $query.=" ORDER BY " . $order_by . " " . $order;
            $query.=" LIMIT " . $offset . " , " . $limit;

            $result = $this->db->query($query);
            $productos = $result->result();

            $query_total = "SELECT FOUND_ROWS() as rows;";
            $result_total = $this->db->query($query_total);
            $total = $result_total->row();

            if ($total->rows > 0) {
                if (sizeof($productos) == 0) {
                    return $this->get_site_search($params, $limit, 0, $order_by, $order);
                } else {
                    return array("productos" => $productos, "total" => $total->rows);
                }
            } else {
                return array("total" => 0);
            }
        } else {
            /*             * -------------------------------------------------------------------------
             * 
             * Busqueda cuando no se haya iniciado sesion, no incluimos ni tarifas ni ofertas
             *
             * ------------------------------------------------------------------------- 
             */
            $query = "SELECT SQL_CALC_FOUND_ROWS p.*, pr.filename as imagen_nombre, vd.filename as imagen_vendedor, ";

            if (isset($params["order_by_grupo_txt"])) {
                $familia = (isset($params["order_by_familia_txt"]) ? $params["order_by_familia_txt"] : '');
                $subfamilia = (isset($params["order_by_subfamilia_txt"]) ? $params["order_by_subfamilia_txt"] : '');
                $query.="(MATCH (grupo_txt) AGAINST ('" . $params["order_by_grupo_txt"] . "' IN BOOLEAN MODE) * 3 + ";
                $query.="MATCH (familia_txt) AGAINST ('" . $familia . "' IN BOOLEAN MODE) * 2 + ";
                $query.="MATCH (subfamilia_txt) AGAINST ('" . $subfamilia . "' IN BOOLEAN MODE) ";
                $query.=") as relevance ";
            } else {
                $query.=" '0' as relevance ";
            }

            $query.= "FROM (SELECT * FROM  `productos_precios` ORDER BY nuevo_costo DESC ) as p ";
            $query.="LEFT JOIN producto_resource pr ON pr.producto_id = p.id AND pr.tipo='imagen_principal' ";
            $query.="INNER JOIN vendedor vd ON vd.id = p.vendedor_id ";
            $query.="INNER JOIN productos_localizacion pl ON pl.producto_id = p.id ";

            $query.="WHERE ( 1";
            $sub_query = "";
            if (isset($params['search_query'])) {
                $text = " AND (p.nombre LIKE '%" . $params['search_query'] . "%' OR p.descripcion LIKE '%" . $params['search_query'] . "%' ) ";
                $query.=$text;
                $sub_query.=$text;
            }
            if (isset($params['nombre'])) {
                $text = " AND p.nombre LIKE '%" . $params['nombre'] . "%'";
                $query.=$text;
                $sub_query.=$text;
            }
            if (isset($params['descripcion'])) {
                $text = " AND p.descripcion LIKE '%" . $params['descripcion'] . "%'";
                $sub_query.=$text;
            }
            if (isset($params['categoria_id'])) {
                //$arriba = $this->get_categorias_arbol($params['categoria_id']);
                $arriba[] = $params['categoria_id'];
                $abajo = $this->get_all_categorias_of($params['categoria_id']);
                if ($abajo) {
                    $categorias_array = array_merge($arriba, $abajo);
                } else {
                    $categorias_array = $arriba;
                }

                $text = " AND p.categoria_id IN(" . implode(",", $categorias_array) . ")";
                $query.=$text;
                $sub_query.=$text;
            }

            if (isset($params['precio_desde'])) {
                $text = " AND p.precio >= '" . $params['precio_desde'] . "' ";
                $query.=$text;
                $sub_query.=$text;
            }
            if (isset($params['precio_hasta'])) {
                $text = " AND p.precio <= '" . $params['precio_hasta'] . "' ";
                $query.=$text;
                $sub_query.=$text;
            }
            if (isset($params["poblacion"])) {
                if ($params['poblacion'] != '0') {
                    $text = " AND pl.poblacion_id='" . $params['poblacion'] . "' ";
                    $query.=$text;
                    $sub_query.=$text;
                }
            }
            if (isset($params["provincia"])) {
                if ($params['provincia'] != '0') {
                    $text = " AND pl.provincia_id='" . $params['provincia'] . "' ";
                    $query.=$text;
                    $sub_query.=$text;
                }
            }
            if (isset($params["pais"])) {
                if ($params['pais'] != '0') {
                    $text = " AND pl.pais_id='" . $params['pais'] . "' ";
                    $query.=$text;
                    $sub_query.=$text;
                }
            }
            if (isset($params['vendedor_id'])) {
                $text = " AND p.vendedor_id='" . $params['vendedor_id'] . "' ";
                $query.=$text;
                $sub_query.=$text;
            }
            if (isset($params['excluir_vendedor_id'])) {
                $text = " AND p.vendedor_id!='" . $params['excluir_vendedor_id'] . "' ";
                $query.=$text;
                $sub_query.=$text;
            }
            if (isset($params['excluir_producto_id'])) {
                $ids = implode(",", $params['excluir_producto_id']);
                $text = " AND p.id NOT IN(" . $ids . ")";
                $query.=$text;
                $sub_query.=$text;
            }
            if (isset($params['mostrar_producto'])) {
                $text = " AND p.mostrar_producto='" . $params['mostrar_producto'] . "' ";
                $query.=$text;
                $sub_query.=$text;
            }
            if (isset($params["grupo_txt"])) {
                $text = " AND p.grupo_txt='" . $params["grupo_txt"] . "'";
                $query.=$text;
                $sub_query.=$text;
            }
            if (isset($params["familia_txt"])) {
                $text = " AND p.familia_txt='" . $params["familia_txt"] . "'";
                $query.=$text;
                $sub_query.=$text;
            }
            if (isset($params["subfamilia_txt"])) {
                $text = " AND p.subfamilia_txt='" . $params["subfamilia_txt"] . "'";
                $query.=$text;
                $sub_query.=$text;
            }

            $query.=") ";

            if (isset($params["habilitado"])) {
                $query.=" AND p.habilitado='" . $params['habilitado'] . "' ";
            }
            $query.=" GROUP BY p.id";
            $query.=" ORDER BY " . $order_by . " " . $order;
            $query.=" LIMIT " . $offset . " , " . $limit;

            $result = $this->db->query($query);
            $productos = $result->result();

            $query_total = "SELECT FOUND_ROWS() as rows;";
            $result_total = $this->db->query($query_total);
            $total = $result_total->row();

            if ($total->rows > 0) {
                if (sizeof($productos) == 0) {
                    return $this->get_site_search($params, $limit, 0, $order_by, $order);
                } else {
                    return array("productos" => $productos, "total" => $total->rows);
                }
            } else {
                return array("total" => 0);
            }
        }
    }

    /**
     * Devuelve todas las categorias incluidas
     * @param type $id
     * @return boolean
     */
    public function get_all_categorias_of($id) {
        $this->db->cache_on();
        $query = "SELECT id FROM categoria WHERE padre_id='" . $id . "'";
        $result = $this->db->query($query);
        $categorias = $result->result_array();
        $this->db->cache_off();
        $ids = array();
        if ($categorias) {
            foreach ($categorias as $value) {
                $ids[] = $value["id"];
                $res = $this->get_all_categorias_of($value['id']);
                if ($res) {
                    foreach ($res as $val) {
                        $ids[] = $val;
                    }
                }
            }
            return $ids;
        } else {
            return false;
        }
    }

    /**
     * Devuelve todas las categorias padre hasta la raiz
     * @param type $id
     * @return boolean
     */
    public function get_categorias_arbol($id) {
        $query = "SELECT padre_id FROM categoria WHERE id='" . $id . "'";
        $result = $this->db->query($query);
        $categoria = $result->row();

        $ids = array();
        if ($categoria) {
            if ($categoria->padre_id != '0') {
                $ids[] = $categoria->padre_id;
                $res = $this->get_categorias_arbol($categoria->padre_id);
                if ($res) {
                    foreach ($res as $val) {
                        $ids[] = $val;
                    }
                }
            } else {
                return false;
            }
            return $ids;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $producto_id
     * @return boolean
     */
    public function get_vendedor_id_del_producto($producto_id) {
        $producto = $this->get($producto_id);
        if ($producto) {
            return $producto->vendedor_id;
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param type $vendedor_id
     * @param type $count
     * @return boolean
     */
    public function get_ultimos_productos_ids($vendedor_id, $count) {
        $this->db->select('id');
        $this->db->from('producto');
        $this->db->where("vendedor_id", $vendedor_id);
        $this->db->order_by("id", "desc");
        $this->db->limit($count, 0);
        $response = $this->db->get()->result_array();

        if ($response) {
            $producto_ids = array();
            foreach ($response as $val) {
                $producto_ids[] = $val['id'];
            }
            return $producto_ids;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $params
     */
    public function habilitar_productos($params) {
        $data = array("habilitado" => 1);
        if (isset($params["limit"]) && isset($params["vendedor_id"])) {
            $ids = $this->get_ultimos_productos_ids($params["vendedor_id"], $params["limit"]);

            $this->db->where_in('id', $ids);
            $this->db->where('vendedor_id', $params["vendedor_id"]);
        }
        $this->db->update("producto", $data);
        return $this->db->affected_rows();
    }

    /**
     * 
     * @param array $producto
     * @return type
     */
    protected function pre_insertado($producto) {
        $config = array(
            'table' => 'producto',
            'id' => 'id',
            'field' => 'unique_slug',
            'title' => 'nombre',
            'replacement' => 'dash' // Either dash or underscore
        );
        $this->load->library('slug', $config);

        $producto['fecha_insertado'] = date('Y-m-d');
        $producto['unique_slug'] = $this->slug->create_uri($producto['nombre']);
        return $producto;
    }

    /**
     * 
     * @param type $producto_id
     * @param type $precio
     * @return boolean
     */
    public function verificar_cambio_precio($producto_id, $precio) {
        $producto = $this->get($producto_id);
        if ($producto->precio != $precio) {
            $this->update($producto_id, array("fecha_precio_modificar" => date('Y-m-d'), "precio_anterior" => $producto->precio));
        } else {
            return false;
        }
    }

    /*
     * 
     */

    public function inhabilitar($producto_id) {
        $this->update($producto_id, array("habilitado" => "0"));
    }

    /*
     * 
     */

    public function habilitar($producto_id) {
        $this->update($producto_id, array("habilitado" => "1"));
    }

    public function get_tarifas_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("DISTINCT producto.id,producto.*,categoria.nombre AS Categoria", false);
        $this->db->from($this->_table);
        $this->db->join("categoria", "categoria.id=producto.categoria_id", 'INNER');
        $this->db->join("vendedor", "vendedor.id=producto.vendedor_id", 'INNER');

        if (isset($params['tarifa_general_id'])) {
            $this->db->join("tarifa", "tarifa.producto_id=producto.id AND tarifa.tarifa_general_id='" . $params["tarifa_general_id"] . "'", 'INNER');
        }

        if (isset($params['nombre'])) {
            $this->db->like('producto.nombre', $params['nombre'], 'both');
        }
        if (isset($params['categoria_id'])) {
            $this->db->where('producto.categoria_id', $params['categoria_id']);
        }
        if (isset($params['vendedor_id'])) {
            $this->db->where('vendedor.id', $params['vendedor_id']);
        }
        if (isset($params['incluir_ids'])) {
            $this->db->where_in('producto.id', $params['incluir_ids']);
        }
        if (isset($params['excluir_ids'])) {
            $this->db->where_not_in('producto.id', $params['excluir_ids']);
        }


        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('producto.id', 'asc');
            if ($limit) {
                $this->db->limit($limit, $offset);
            }
            $productos = $this->db->get()->result();
            $this->db->flush_cache();
            return array("productos" => $productos, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    /**
     * Full Delete de un producto
     * @param type $id
     */
    public function delete($id) {
        $this->producto_resource_model->cleanup_resources($id);
        $this->producto_extra_model->delete_by("producto_id", $id);
        $this->visita_model->delete_by("producto_id", $id);
        $this->requisito_visitas_model->delete_by("producto_id", $id);

        $tarifas = $this->tarifa_model->get_many_by("producto_id", $id);
        if ($tarifas) {
            foreach ($tarifas as $tarifa) {
                $this->tarifa_model->delete($tarifa->id);
            }
        }

        $ofertas = $this->oferta_model->get_many_by("producto_id", $id);
        if ($ofertas) {
            foreach ($ofertas as $oferta) {
                $this->oferta_model->delete($oferta->id);
            }
        }

        parent::delete($id);
    }

    /**
     * 
     * @param type $producto_id
     * @param type $cliente_id
     * @return boolean
     */
    public function get_tarifas_from_producto($producto_id, $cliente_id) {
        $this->db->select('*');
        $this->db->from('productos_precios pp');
        $this->db->where('pp.id', $producto_id);
        $this->db->where('pp.cliente_id', $cliente_id);
        $this->db->where('pp.tipo', 'tarifa');

        $tarifas = $this->db->get()->row();
        if (count($tarifas) > 0) {
            return $tarifas;
        } else {
            return false;
        }
    }

    public function get_ofertas_from_producto($producto_id, $cliente_id = false) {
        // TODO : Validar el rango de fechas que sea presente
        $this->db->select('*');
        $this->db->from('productos_precios pp');
        $this->db->where('pp.id', $producto_id);
        if ($cliente_id) {
            $this->db->where('pp.cliente_id', $cliente_id);
        }
        $this->db->where('pp.fecha_inicio <=', date("Y-m-d"));
        $this->db->where('pp.fecha_finaliza >=', date("Y-m-d"));
        $this->db->where('pp.tipo', 'oferta');

        $ofertas = $this->db->get()->row();
        if (count($ofertas) > 0) {
            return $ofertas;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function get_ofertas_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("DISTINCT producto.id,producto.*,categoria.nombre AS Categoria", false);
        $this->db->from($this->_table);
        $this->db->join("categoria", "categoria.id=producto.categoria_id", 'INNER');
        $this->db->join("vendedor", "vendedor.id=producto.vendedor_id", 'INNER');

        if (isset($params['solo_ofertados'])) {
            $this->db->join("oferta", "oferta.producto_id=producto.id", 'INNER');
        }

        if (isset($params['nombre'])) {
            $this->db->like('producto.nombre', $params['nombre'], 'both');
        }
        if (isset($params['categoria_id'])) {
            $this->db->where('producto.categoria_id', $params['categoria_id']);
        }
        if (isset($params['vendedor_id'])) {
            $this->db->where('vendedor.id', $params['vendedor_id']);
        }
        if (isset($params['incluir_ids'])) {
            $this->db->where_in('producto.id', $params['incluir_ids']);
        }
        if (isset($params['excluir_ids'])) {
            $this->db->where_not_in('producto.id', $params['excluir_ids']);
        }

        $this->db->stop_cache();
        $count = count($this->db->get()->result());

        if ($count > 0) {
            $this->db->order_by('producto.id', 'asc');
            $this->db->limit($limit, $offset);
            $productos = $this->db->get()->result();
            $this->db->flush_cache();
            return array("productos" => $productos, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    public function get_novedades_fecha($fecha_inicio, $fecha_final, $limit, $vendedores_id = false) {
        $query = "SELECT COUNT(vi.cliente_id) as visitas,p.*,pr.filename as imagen_nombre ";
        $query.="FROM producto p ";
        $query.="LEFT JOIN visita vi ON vi.producto_id=p.id ";
        $query.="LEFT JOIN producto_resource pr ON pr.producto_id = p.id AND pr.tipo='imagen_principal' ";

        $query.="WHERE p.fecha_insertado >= '" . $fecha_inicio . "' AND p.fecha_insertado <= '" . $fecha_final . "'";

        if ($vendedores_id) {
            $ids = implode(",", $vendedores_id);
            $query.=" AND p.vendedor_id IN(" . $ids . ")";
        }

        $query.=" GROUP BY p.id";
        $query.=" ORDER BY visitas DESC,p.fecha_insertado DESC";

        if ($limit) {
            $query.=" LIMIT 0 ," . $limit;
        }

        $result = $this->db->query($query);
        $productos = $result->result();

        if ($productos) {
            return $productos;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $producto_id
     */
    public function verificar_oferta($producto_id) {
        $producto = $this->get($producto_id);
        if ($producto) {
            $oferta = $this->oferta_model->get_by("producto_id", $producto_id);
            $user_id = $this->authentication->read('identifier');
            $usuario = $this->usuario_model->get_full_identidad($user_id);

            if ($oferta) {
                $grupo_oferta = $this->grupo_oferta_model->get_by(array("cliente_id" => $usuario->cliente->id, "oferta_general_id" => $oferta->oferta_general_id));
                if (!$grupo_oferta) {
                    if ($this->requisito_visitas_model->cumple_todos_requisitos($oferta->oferta_general_id, $usuario->cliente->id)) {
                        $codigo = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 15));
                        $data = array(
                            "cliente_id" => $usuario->cliente->id,
                            "oferta_general_id" => $oferta->oferta_general_id,
                            "codigo" => $codigo
                        );
                        $this->grupo_oferta_model->insert($data);
                        if ($this->config->item('emails_enabled')) {
                            $oferta_general = $this->oferta_general_model->get($oferta->oferta_general_id);

                            $this->load->library('email');
                            $this->email->initialize($this->config->item('email_info'));
                            $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                            $this->email->to($usuario->usuario->email);
                            $this->email->subject('Requisitos de Oferta cumplidos');
                            $data_mail = array("codigo" => $codigo, "producto" => $producto, "oferta" => $oferta, "oferta_general" => $oferta_general);
                            $this->email->message($this->load->view('home/emails/cumplido_requisitos_oferta_cliente', $data_mail, true));
                            $this->email->send();

                            $this->email->clear();

                            $email = $this->vendedor_model->get_email($producto->vendedor_id);
                            $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                            $this->email->to($email);
                            $this->email->subject('Requisitos de Oferta cumplidos');
                            $data_mail2 = array("codigo" => $codigo, "oferta_general" => $oferta_general);
                            $this->email->message($this->load->view('home/emails/cumplido_requisitos_oferta_vendedor', $data_mail2, true));
                            $this->email->send();
                        }
                    }
                }
            }

            $requisitos = $this->requisito_visitas_model->get_many_by("producto_id", $producto_id);
            if ($requisitos) {
                foreach ($requisitos as $req) {
                    if ($this->requisito_visitas_model->cumple_todos_requisitos($req->oferta_general_id, $usuario->cliente->id)) {
                        $codigo = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 15));
                        $data = array(
                            "cliente_id" => $usuario->cliente->id,
                            "oferta_general_id" => $req->oferta_general_id,
                            "codigo" => $codigo
                        );
                        $this->grupo_oferta_model->insert($data);

                        if ($this->config->item('emails_enabled')) {
                            $oferta_general = $this->oferta_general_model->get($req->oferta_general_id);
                            $oferta = $this->oferta_model->get_by("oferta_general_id", $req->oferta_general_id);
                            $producto = $this->producto_model->get($oferta->producto_id);

                            $this->load->library('email');
                            $this->email->initialize($this->config->item('email_info'));
                            $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                            $this->email->to($usuario->usuario->email);
                            $this->email->subject('Requisitos de Oferta cumplidos');
                            $data_mail = array("codigo" => $codigo, "producto" => $producto, "oferta" => $oferta, "oferta_general" => $oferta_general);
                            $this->email->message($this->load->view('home/emails/cumplido_requisitos_oferta_cliente', $data_mail, true));
                            $this->email->send();

                            $this->email->clear();

                            $email = $this->vendedor_model->get_email($producto->vendedor_id);
                            $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                            $this->email->to($email);
                            $this->email->subject('Requisitos de Oferta cumplidos');
                            $data_mail2 = array("codigo" => $codigo, "oferta_general" => $oferta_general);
                            $this->email->message($this->load->view('home/emails/cumplido_requisitos_oferta_vendedor', $data_mail2, true));
                            $this->email->send();
                        }
                    }
                }
            }
        }
    }

    public function get_pp_by($producto_id) {
        $this->db->select('pp.*,pr.filename as imagen_nombre');
        $this->db->from('productos_precios pp');
        $this->db->join("producto_resource pr", "pr.producto_id = pp.id AND pr.tipo='imagen_principal'", 'LEFT');
        $this->db->where('pp.id', $producto_id);

        $results = $this->db->get()->row();
        if ($results) {
            return $results;
        } else {
            return false;
        }
    }

    public function get_visitas_search($params, $limit, $offset) {
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM ( ";
        $query.= "SELECT producto.*,COUNT(visita.id) as total  FROM producto ";
        $query.= "INNER JOIN visita ON visita.producto_id=producto.id ";

        if (isset($params['vendedor_id'])) {
            $query.= "WHERE producto.vendedor_id='" . $params["vendedor_id"] . "' ";
        }

        $query.=" GROUP BY producto.id";
        $query.=" ) p ";
        $query.=" ORDER BY id";
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



        /* $this->db->start_cache();
          $this->db->select("producto.*,COUNT(visita.id) as total");
          $this->db->from($this->_table);
          $this->db->join("visita", "visita.producto_id=producto.id", 'INNER');

          if (isset($params['vendedor_id'])) {
          $this->db->where('producto.vendedor_id', $params['vendedor_id']);
          }

          $this->db->group_by('producto.id');

          $this->db->stop_cache();
          $count = $this->db->count_all_results();

          if ($count > 0) {
          $this->db->order_by('producto.id', 'asc');
          $this->db->limit($limit, $offset);
          $productos = $this->db->get()->result();
          $this->db->flush_cache();
          return array("productos" => $productos, "total" => $count);
          } else {
          $this->db->flush_cache();
          return array("total" => 0);
          } */
    }

    public function get_productos_tarifas($params) {
        $query = "SELECT * FROM (";
        $query.= " SELECT * FROM productos_precios pp ";
        $query.="WHERE 1 ";

        if (isset($params['cliente_id'])) {
            $query.= "AND ( pp.cliente_id='" . $params["cliente_id"] . "' AND pp.tipo='tarifa' ) ";
        }

        if (isset($params["producto_ids"])) {
            $ids = implode(",", $params["producto_ids"]);
            $query.=" AND pp.id IN(" . $ids . ")";
        }

        $query.=" UNION ALL ";

        $query.= " SELECT * FROM productos_precios pp ";
        $query.="WHERE 1 ";

        if (isset($params['cliente_id'])) {
            $query.= "AND pp.tipo='normal' ";
        }

        if (isset($params["producto_ids"])) {
            $ids = implode(",", $params["producto_ids"]);
            $query.=" AND pp.id IN(" . $ids . ")";
        }

        $query.=") a ";
        $query.=" GROUP BY id";

        $result = $this->db->query($query);
        $productos = $result->result();

        if (sizeof($productos) > 0) {
            return $productos;
        } else {
            return false;
        }

        /* $this->db->select('*');
          $this->db->from('productos_precios pp');
          $this->db->where('pp.tipo', "tarifa");
          $this->db->or_where('pp.tipo', "normal");

          if (isset($params["producto_ids"])) {
          $this->db->where_in('pp.id', $params["producto_ids"]);
          }

          if (isset($params["cliente_id"])) {
          $this->db->where('pp.cliente_id', $params["cliente_id"]);
          }

          $this->db->group_by("pp.id");

          $results = $this->db->get()->result();
          if ($results) {
          return $results;
          } else {
          return false;
          } */
    }

}
