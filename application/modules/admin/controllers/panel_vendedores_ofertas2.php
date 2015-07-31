<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_ofertas2 extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->_validar_vendedor_habilitado();
    }
    
    public function view_listado() {
        $paquete = $this->vendedor_model->get_paquete_en_curso($this->identidad->get_vendedor_id());

        if ($paquete->limite_productos != "0") {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');

            $this->template->add_js("modules/admin/panel_vendedores/ofertas2/ofertas_listado.js");
            $categorias = $this->categoria_model->get_all();
            $data = array("categorias" => $categorias);
            $this->template->load_view('admin/panel_vendedores/ofertas2/listado', $data);
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->load_view('admin/panel_vendedores/producto/producto_limite');
        }
    }

    public function nueva_oferta() {
        $paquete = $this->vendedor_model->get_paquete_en_curso($this->identidad->get_vendedor_id());

        if ($paquete->limite_productos != "0") {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->add_js("modules/admin/panel_vendedores/ofertas2/ofertas_crear.js");
            $this->template->load_view('admin/panel_vendedores/ofertas2/detalles_oferta');
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->load_view('admin/panel_vendedores/prodBucto/producto_limite');
        }
    }

    public function crear_oferta() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $data_oferta_general = array(
                "nombre" => ($this->input->post('nombre') != '') ? $this->input->post('nombre') : null,
                "descripcion" => ($this->input->post('descripcion') != '') ? $this->input->post('descripcion') : null,
                "porcentaje" => null,
                "fecha_inicio" => ($this->input->post('fecha_inicio') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_inicio'))) : null,
                "fecha_finaliza" => ($this->input->post('fecha_finaliza') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_finaliza'))) : null,
                "owner_vendedor_id" => $this->identidad->get_vendedor_id(),
                "grupo" => ($this->input->post('grupo') != '') ? $this->input->post('grupo') : null
            );

            $oferta_general_id = $this->oferta_general_model->insert($data_oferta_general);
            redirect('panel_vendedor/ofertas/ver-oferta/' . $oferta_general_id);
        }
    }

    public function ver_oferta($oferta_general_id) {
        $oferta_general = $this->oferta_general_model->get($oferta_general_id);
        if ($oferta_general) {
            $vendedor_owner = $this->oferta_general_model->get_vendedor($oferta_general_id);
            if ($vendedor_owner == $this->identidad->get_vendedor_id() || !$vendedor_owner) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $data = array("oferta_general" => $oferta_general);
                $this->template->add_js("modules/admin/panel_vendedores/ofertas2/ofertas_editar.js");
                $this->template->load_view('admin/panel_vendedores/ofertas2/oferta_editar', $data);
            } else {
                redirect('panel_vendedor/ofertas/listado');
                // TODO: Accesando una oferta que no es tuya
            }
        } else {
            redirect('panel_vendedor/ofertas/listado');
        }
    }

    public function modificar_productos($oferta_general_id) {
        $oferta_general = $this->oferta_general_model->get($oferta_general_id);
        if ($oferta_general) {
            $vendedor_owner = $this->oferta_general_model->get_vendedor($oferta_general_id);
            if ($vendedor_owner == $this->identidad->get_vendedor_id() || !$vendedor_owner) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $data = array("oferta_general" => $oferta_general);                
                $this->template->add_js("modules/admin/panel_vendedores/ofertas2/ofertas_editar_productos.js");
                $this->template->load_view('admin/panel_vendedores/ofertas2/oferta_editar_productos', $data);
            } else {
                redirect('panel_vendedor/ofertas/listado');
                // TODO: Accesando una tarifa que no es tuya
            }
        } else {
            redirect('panel_vendedor/ofertas/listado');
        }
    }
    
    public function borrar($id) {
        if ($this->input->is_ajax_request()) {
            $oferta_id = $id;

            $res = $this->oferta_general_model->get_vendedor_id_de_oferta($oferta_id);
            if ($res == $this->identidad->get_vendedor_id()) {
                $this->oferta_general_model->delete($oferta_id);
                $this->session->set_flashdata('success', 'Oferta eliminada con exito..');
            } else {
                $this->session->set_flashdata('error', 'No puedes realizar esta accion.');
            }
            echo json_encode(array("success" => true));
        } else {
            show_404();
        }
    }
    
    public function modificar_datos($oferta_general_id) {
        $oferta_general = $this->oferta_general_model->get($oferta_general_id);
        if ($oferta_general) {
            $vendedor_owner = $this->oferta_general_model->get_vendedor($oferta_general_id);
            if ($vendedor_owner == $this->identidad->get_vendedor_id() || !$vendedor_owner) {
                $formValues = $this->input->post();
                if ($formValues !== false) {
                    
                    $data_oferta_general = array(
                        "nombre" => ($this->input->post('nombre') != '') ? $this->input->post('nombre') : null,
                        "descripcion" => ($this->input->post('descripcion') != '') ? $this->input->post('descripcion') : null,                        
                        "fecha_inicio" => ($this->input->post('fecha_inicio') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_inicio'))) : null,
                        "fecha_finaliza" => ($this->input->post('fecha_finaliza') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_finaliza'))) : null,
                        "grupo" => ($this->input->post('grupo') != '') ? $this->input->post('grupo') : null
                    );

                    $this->oferta_general_model->update($oferta_general_id,$data_oferta_general);
                    redirect('panel_vendedor/ofertas/ver-oferta/'.$oferta_general->id);
                } else {
                    $this->template->set_title("Panel de Control - Mercabarato.com");
                    $this->template->set_layout('panel_vendedores');
                    $data = array("oferta_general" => $oferta_general);
                    $this->template->add_js("modules/admin/panel_vendedores/ofertas2/ofertas_editar_datos.js");
                    $this->template->load_view('admin/panel_vendedores/ofertas2/oferta_editar_datos', $data);
                }
            } else {
                redirect('panel_vendedor/ofertas/listado');
                // TODO: Accesando una oferta que no es tuya
            }
        } else {
            redirect('panel_vendedor/ofertas/listado');
        }
    }
    
    public function modificar_requisitos($oferta_general_id) {
        $oferta_general = $this->oferta_general_model->get($oferta_general_id);
        if ($oferta_general) {
            $vendedor_owner = $this->oferta_general_model->get_vendedor($oferta_general_id);
            if ($vendedor_owner == $this->identidad->get_vendedor_id() || !$vendedor_owner) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $data = array("oferta_general" => $oferta_general);                
                $this->template->add_js("modules/admin/panel_vendedores/ofertas2/ofertas_editar_requisitos.js");
                $this->template->load_view('admin/panel_vendedores/ofertas2/oferta_editar_requisitos', $data);
            } else {
                redirect('panel_vendedor/ofertas/listado');
                // TODO: Accesando una tarifa que no es tuya
            }
        } else {
            redirect('panel_vendedor/ofertas/listado');
        }
    }
    
    public function ver_oferta_clientes($oferta_general_id) {
        $oferta_general = $this->oferta_general_model->get($oferta_general_id);
        if ($oferta_general) {
            $vendedor_owner = $this->oferta_general_model->get_vendedor($oferta_general_id);
            if ($vendedor_owner == $this->identidad->get_vendedor_id() || !$vendedor_owner) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $data = array("oferta_general" => $oferta_general);
                $this->template->add_js("modules/admin/panel_vendedores/ofertas2/ofertas_ver_clientes.js");
                $this->template->load_view('admin/panel_vendedores/ofertas2/oferta_ver_clientes', $data);
            } else {
                redirect('panel_vendedor/ofertas/listado');
                // TODO: Accesando una oferta que no es tuya
            }
        } else {
            redirect('panel_vendedor/ofertas/listado');
        }
    }

}
