<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendedor_paquete extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
    }

    /**
     *  Listado
     */
    public function view_listado_por_activar() {
        $this->template->set_title("Panel de Administracion - Mercabarato.com");
        $this->template->add_js("modules/admin/vendedor_paquete_listado.js");
        $this->template->load_view('admin/vendedor_paquete/listado_por_activar');
    }

    /**
     * ( IMPORTANTE )
     * Aprobamos un vendedor_paquete
     * Verificamos productos y anuncios 
     * @param type $id
     */
    public function aprobar($id) {
        $vendedor_paquete = $this->vendedor_paquete_model->get($id);
        // TODO : Validar la restriccion por si acaso
        $user_id = $this->authentication->read('identifier');
        $this->vendedor_paquete_model->aprobar_paquete($id, $user_id);
        $this->vendedor_model->habilitar_vendedor($vendedor_paquete->vendedor_id);

        $productos = $this->producto_model->get_many_by("vendedor_id", $vendedor_paquete->vendedor_id);
        $anuncios = $this->anuncio_model->get_many_by("vendedor_id", $vendedor_paquete->vendedor_id);

        if (sizeof($productos) <= $vendedor_paquete->limite_productos || $vendedor_paquete->limite_productos == -1) {
            $this->producto_model->update_by(array('vendedor_id' => $vendedor_paquete->vendedor_id), array('habilitado' => 1));
        } else {
            $this->producto_model->update_by(array('vendedor_id' => $vendedor_paquete->vendedor_id), array('habilitado' => 0));
            $this->producto_model->habilitar_productos(array('vendedor_id' => $vendedor_paquete->vendedor_id, "limit" => $vendedor_paquete->limite_productos));
        }

        if (sizeof($anuncios) <= $vendedor_paquete->limite_anuncios || $vendedor_paquete->limite_anuncios == -1) {
            $this->anuncio_model->update_by(array('vendedor_id' => $vendedor_paquete->vendedor_id), array('habilitado' => 1));
        } else {
            $this->anuncio_model->update_by(array('vendedor_id' => $vendedor_paquete->vendedor_id), array('habilitado' => 0));
            $this->anuncio_model->habilitar_anuncios(array('vendedor_id' => $vendedor_paquete->vendedor_id, "limit" => $vendedor_paquete->limite_anuncios));
        }

        if ($this->config->item('emails_enabled')) {
            $vendedor_paqueted = $this->vendedor_paquete_model->get($id);
            $vendedor=$this->vendedor_model->get($vendedor_paquete->vendedor_id);
            $cliente=$this->cliente_model->get($vendedor->cliente_id);
            $usuario=$this->usuario_model->get($cliente->usuario_id);
                    
            $this->load->library('email');
            $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
            $this->email->to($usuario->email);
            $this->email->subject('Paquete Aprobado');
            $data_email = array("paquete" => $vendedor_paqueted);
            $this->email->message($this->load->view('home/emails/paquete_aprobado', $data_email, true));
            $this->email->send();
        }
        $this->session->set_flashdata('success', 'El paquete ha sido aprobado y el Vendedor habilitado.');
        redirect('admin/vendedor_paquetes/listado_por_activar');
    }

    /**
     *  AJAX Productos / Listado
     */
    public function ajax_get_listado_resultados() {
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre_empresa"] = $this->input->post('nombre');
            }
            if ($this->input->post('email') != "") {
                $params["email"] = $this->input->post('email');
            }
            if ($this->input->post('sitioweb') != "") {
                $params["sitioweb"] = $this->input->post('sitioweb');
            }
            if ($this->input->post('actividad') != "No Especificada") {
                $params["actividad"] = $this->input->post('actividad');
            }

            /*$user_id = $this->authentication->read('identifier');
            $restriccion = $this->restriccion_model->get_by("usuario_id", $user_id);
            if ($restriccion) {
                if ($restriccion->pais_id != null) {
                    $params["pais_id"] = $restriccion->pais_id;
                }
                if ($restriccion->provincia_id != null) {
                    unset($params["pais_id"]);
                    $params["provincia_id"] = $restriccion->provincia_id;
                }
                if ($restriccion->poblacion_id != null) {
                    unset($params["pais_id"]);
                    unset($params["provincia_id"]);
                    $params["poblacion_id"] = $restriccion->poblacion_id;
                }
            }*/

            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $vendedor_paquetes_array = $this->vendedor_paquete_model->get_admin_search($params, $limit, $offset);
        $flt = (float) ($vendedor_paquetes_array["total"] / $limit);
        $ent = (int) ($vendedor_paquetes_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }

        if ($vendedor_paquetes_array["total"] == 0) {
            $vendedor_paquetes_array["vendedor_paquetes"] = array();
        }
        $search_params = array(
            "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
            "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
            "pagina" => $pagina,
            "total_paginas" => $paginas,
            "por_pagina" => $limit,
            "total" => $vendedor_paquetes_array["total"],
            "hasta" => ($pagina * $limit < $vendedor_paquetes_array["total"]) ? $pagina * $limit : $vendedor_paquetes_array["total"],
            "desde" => (($pagina * $limit) - $limit) + 1);
        $pagination = build_paginacion($search_params);

        $data = array(
            "vendedor_paquetes" => $vendedor_paquetes_array["vendedor_paquetes"],
            "pagination" => $pagination);

        $this->template->load_view('admin/vendedor_paquete/tabla_resultados', $data);
    }

    /**
     * 
     */
    public function ajax_get_paquete_info() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $vendedor_paquete_id = $this->input->post("vendedor_paquete_id");
                $vendedor_paquete = $this->vendedor_paquete_model->get($vendedor_paquete_id);
                $vendedor = $this->vendedor_model->get($vendedor_paquete->vendedor_id);
                $cliente = $this->cliente_model->get($vendedor->cliente_id);
                $usuario = $this->usuario_model->get($cliente->usuario_id);

                $html = '<table class="table table-bordered table-hover table-striped">';
                $html.='<thead>';
                $html.='<tr>';
                $html.='<th style="width: 15%;text-align:center;">Vendedor / Empresa</th>';
                $html.='<th style="width: 15%;text-align:center;">Monto a Cancelar</th>';
                $html.='<th style="width: 15%;text-align:center;">NIF/CIF</th>';
                $html.='</tr>';
                $html.='</thead>';
                $html.='<tbody>';
                $html.='<tr>';
                $html.='<td>' . $vendedor->nombre . '</td>';
                $html.='<td>' . $vendedor_paquete->monto_a_cancelar . ' ' . $this->config->item('money_sign') . '</td>';
                $html.='<td>' . $vendedor->nif_cif . '</td>';
                $html.='</tr>';
                $html.='</tbody>';
                $html.='</table>';

                echo $html;
            }
        }
    }

}
