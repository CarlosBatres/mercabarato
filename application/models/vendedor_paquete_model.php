<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Vendedor_paquete_model extends MY_Model {

    function __construct() {
        parent::__construct();
        $this->_table = "vendedor_paquete";
    }

    /**
     * Funcion para el search del admin
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function get_admin_search($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("vendedor_paquete.*,vendedor.nombre AS Vendedor,usuario.email,vendedor.nif_cif");
        $this->db->from($this->_table);
        $this->db->join("vendedor", "vendedor.id=vendedor_paquete.vendedor_id", 'INNER');
        $this->db->join("cliente", "cliente.id=vendedor.cliente_id", 'INNER');
        $this->db->join("usuario", "usuario.id=cliente.usuario_id", 'INNER');
        $this->db->join("localizacion", "localizacion.usuario_id=usuario.id", 'INNER');

        if (isset($params['nombre_empresa'])) {
            $this->db->like('vendedor.nombre', $params['nombre_empresa'], 'both');
        }
        if (isset($params['email'])) {
            $this->db->like('usuario.email', $params['email'], 'both');
        }
        if (isset($params['sitioweb'])) {
            $this->db->like('vendedor.sitio_web', $params['sitioweb'], 'both');
        }
        if (isset($params['actividad'])) {
            $this->db->like('vendedor.actividad', $params['actividad'], 'both');
        }

        if (isset($params['pais_id'])) {
            $this->db->where('localizacion.pais_id', $params['pais_id']);
        }
        if (isset($params['provincia_id'])) {
            $this->db->where('localizacion.provincia_id', $params['provincia_id']);
        }
        if (isset($params['poblacion_id'])) {
            $this->db->where('localizacion.poblacion_id', $params['poblacion_id']);
        }

        $this->db->where("vendedor_paquete.aprobado", "0");
        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('vendedor_paquete.fecha_comprado', 'desc');
            $this->db->limit($limit, $offset);
            $vendedor_paquetes = $this->db->get()->result();
            $this->db->flush_cache();
            return array("vendedor_paquetes" => $vendedor_paquetes, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    /**
     * ( IMPORTANTE )
     * Funcion para aprobar un paquete de un vendedor
     * @param type $id del vendedor_paquete
     */
    public function aprobar_paquete($id, $user_id) {
        $vendedor_paquete = $this->get($id);
        $periodo = $vendedor_paquete->duracion_paquete;

        if ($vendedor_paquete->fecha_inicio != null) {
            $fecha_inicio = $vendedor_paquete->fecha_inicio;
        } else {
            $fecha_inicio = date("Y-m-d");
        }

        $data = array(
            "fecha_aprobado" => date("Y-m-d"),
            "aprobado" => 1,
            "fecha_terminar" => date('Y-m-d', strtotime("+$periodo months", strtotime($fecha_inicio))),
            "autorizado_por" => $user_id,
            "fecha_inicio" => $fecha_inicio
        );
        $this->update($id, $data);

        $vendedor = $this->vendedor_model->get($vendedor_paquete->vendedor_id);
        $this->cliente_model->update($vendedor->cliente_id, array("es_vendedor" => "1"));
    }

    /**
     * Devuelve los paquetes de un vendedor
     * @param type $vendedor_id
     * @return boolean
     */
    public function get_paquetes_por_vendedor($vendedor_id) {
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->where("vendedor_id", $vendedor_id);
        $this->db->order_by('fecha_comprado', 'desc');
        $this->db->limit(10);
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param type $params
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public function buscar_vendedores($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("vendedor.*,cliente.direccion,cliente.telefono_fijo,cliente.telefono_movil,cliente.usuario_id,usuario.email,usuario.ultimo_acceso,usuario.ip_address,"
                . "pais.nombre as pais,provincia.nombre as provincia,poblacion.nombre as poblacion");
        $this->db->from("vendedor");
        $this->db->join("cliente", "cliente.id=vendedor.cliente_id", 'INNER');
        $this->db->join("usuario", "usuario.id=cliente.usuario_id", 'INNER');
        $this->db->join("localizacion", "usuario.id=localizacion.usuario_id", 'LEFT');
        $this->db->join("pais", "pais.id=localizacion.pais_id", 'LEFT');
        $this->db->join("provincia", "provincia.id=localizacion.provincia_id", 'LEFT');
        $this->db->join("poblacion", "poblacion.id=localizacion.poblacion_id", 'LEFT');
        $this->db->join("vendedor_paquete", "vendedor_paquete.vendedor_id=vendedor.id", 'INNER');

        $this->db->where('vendedor.habilitado', '1'); // Permitir vendedores no habilitados ??

        if (isset($params['infocompra'])) {
            $this->db->where('vendedor_paquete.infocompra', $params['infocompra']);
        }
        if (isset($params['paquete_vigente'])) {
            $this->db->where('vendedor_paquete.aprobado', '1');
            $this->db->where('vendedor_paquete.fecha_terminar >=', date('Y-m-d'));
        }
        if (isset($params['not_vendedor'])) {
            $this->db->where_not_in('vendedor.id', $params["not_vendedor"]);
        }

        if (isset($params['poblacion'])) {
            $this->db->where('localizacion.poblacion_id', $params['poblacion']);
        } elseif (isset($params['provincia'])) {
            $this->db->where('localizacion.provincia_id', $params['provincia']);
        } elseif (isset($params['pais'])) {
            $this->db->where('localizacion.pais_id', $params['pais']);
        }


        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('vendedor.id', 'asc');
            $this->db->limit($limit, $offset);
            $vendedores = $this->db->get()->result();
            $this->db->flush_cache();
            return array("vendedores" => $vendedores, "total" => $count);
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
    public function find_paquetes($params, $limit, $offset) {
        $this->db->start_cache();
        $this->db->select("vendedor_paquete.*,vendedor.nombre AS vendedor_nombre,usuario.email,usuario.ultimo_acceso");
        $this->db->from($this->_table);
        $this->db->join("vendedor", "vendedor.id=vendedor_paquete.vendedor_id", 'INNER');
        $this->db->join("cliente", "cliente.id=vendedor.cliente_id", 'INNER');
        $this->db->join("usuario", "usuario.id=cliente.usuario_id", 'INNER');

        if (isset($params['autorizado_por'])) {
            $this->db->where('vendedor_paquete.autorizado_por', $params['autorizado_por']);
        }

        if (isset($params['aprobado'])) {
            $this->db->where("vendedor_paquete.aprobado", isset($params['aprobado']));
        }


        $this->db->stop_cache();
        $count = $this->db->count_all_results();

        if ($count > 0) {
            $this->db->order_by('vendedor_paquete.fecha_comprado', 'desc');
            $this->db->limit($limit, $offset);
            $vendedor_paquetes = $this->db->get()->result();
            $this->db->flush_cache();
            return array("vendedor_paquetes" => $vendedor_paquetes, "total" => $count);
        } else {
            $this->db->flush_cache();
            return array("total" => 0);
        }
    }

    /**
     * 
     * @return boolean
     */
    public function get_paquetes_a_caducar($days = 0) {
        $this->db->select("*");
        $this->db->from($this->_table);
        $this->db->where('aprobado', '1');

        if ($days != 0) {
            $date = strtotime(date('Y-m-d'));
            $date = strtotime("+" . $days . " day", $date);
            $this->db->where('fecha_terminar =', date("Y-m-d", $date));
        } else {
            $this->db->where('fecha_terminar <', date('Y-m-d'));
        }


        $this->db->order_by('fecha_terminar', 'desc');
        $result = $this->db->get();

        if ($result->num_rows() > 0) {
            return $result->result();
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param type $vendedor_paquete_id
     */
    public function paquete_vencido($vendedor_paquete_id) {
        $paquete = $this->get($vendedor_paquete_id);
        if ($paquete) {
            $vigente = $this->vendedor_model->get_paquete_en_curso($paquete->vendedor_id);
            if (!$vigente) {
                $this->vendedor_model->inhabilitar($paquete->vendedor_id);
            } else {
                
                
                $productos = $this->producto_model->get_many_by("vendedor_id", $vigente->vendedor_id);
                $anuncios = $this->anuncio_model->get_many_by("vendedor_id", $vigente->vendedor_id);

                if (sizeof($productos) <= $vigente->limite_productos || $vigente->limite_productos == -1) {
                    $this->producto_model->update_by(array('vendedor_id' => $vigente->vendedor_id), array('habilitado' => 1));
                } else {
                    $this->producto_model->update_by(array('vendedor_id' => $vigente->vendedor_id), array('habilitado' => 0));
                    $this->producto_model->habilitar_productos(array('vendedor_id' => $vigente->vendedor_id, "limit" => $vigente->limite_productos));
                }

                if (sizeof($anuncios) <= $vigente->limite_anuncios || $vigente->limite_anuncios == -1) {
                    $this->anuncio_model->update_by(array('vendedor_id' => $vigente->vendedor_id), array('habilitado' => 1));
                } else {
                    $this->anuncio_model->update_by(array('vendedor_id' => $vigente->vendedor_id), array('habilitado' => 0));
                    $this->anuncio_model->habilitar_anuncios(array('vendedor_id' => $vigente->vendedor_id, "limit" => $vigente->limite_anuncios));
                }
            }
        }
    }

}
