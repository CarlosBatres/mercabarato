<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_ofertas extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->_validar_vendedor_habilitado();
    }

    public function nueva_oferta_paso1() {
        $paquete = $this->vendedor_model->get_paquete_en_curso($this->identidad->get_vendedor_id());

        if ($paquete->limite_productos != "0") {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->add_js("modules/admin/panel_vendedores/ofertas_listado_productos.js");

            $this->session->unset_userdata('pv_ofertas_incluir_ids_productos');

            $this->template->load_view('admin/panel_vendedores/ofertas/listado_productos');
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->load_view('admin/panel_vendedores/producto/producto_limite');
        }
    }

    /**
     * 
     */
    public function nueva_seleccion_clientes() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');
        $this->template->add_js("modules/admin/panel_vendedores/ofertas_listado_clientes.js");

        $this->session->unset_userdata('pv_ofertas_incluir_ids_clientes');

        $this->template->load_view('admin/panel_vendedores/ofertas/listado_clientes');
    }

    /**
     * 
     */
    public function detalles_oferta() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');

        $ids_clientes = $this->session->userdata('pv_ofertas_incluir_ids_clientes');
        $ids_productos = $this->session->userdata('pv_ofertas_incluir_ids_productos');

        if ($ids_clientes && $ids_productos) {
            $productos_seleccionados = $ids_productos;
            $mas_de_uno = false;
            if ($productos_seleccionados) {
                if (sizeof($productos_seleccionados) > 1) {
                    $mas_de_uno = true;
                }
            }

            $this->template->add_js("modules/admin/panel_vendedores/ofertas_detalles.js");
            $this->template->load_view('admin/panel_vendedores/ofertas/detalles_oferta', array("mas_de_uno" => $mas_de_uno));
        } else {
            redirect('panel_vendedor');
        }
    }

    /**
     * 
     */
    public function view_listado() {
        $paquete = $this->vendedor_model->get_paquete_en_curso($this->identidad->get_vendedor_id());

        if ($paquete->limite_productos != "0") {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');

            $this->template->add_js("modules/admin/panel_vendedores/ofertas_listado.js");
            $categorias = $this->categoria_model->get_all();
            $data = array("categorias" => $categorias);
            $this->template->load_view('admin/panel_vendedores/ofertas/listado', $data);
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->load_view('admin/panel_vendedores/producto/producto_limite');
        }
    }

    /**
     * 
     * @param type $id
     */
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

    /**
     * 
     */
    public function crear_oferta() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');
            if ($accion === "item-crear") {

                $productos_ids = $this->session->userdata('pv_ofertas_incluir_ids_productos');
                $clientes_ids = $this->session->userdata('pv_ofertas_incluir_ids_clientes');

                if ($this->input->post('tipo') == 'porcentaje') {
                    $porcentaje = $this->input->post('valor');
                } else {
                    $porcentaje = 0;
                }

                $data_oferta_general = array(
                    "nombre" => ($this->input->post('nombre') != '') ? $this->input->post('nombre') : null,
                    "descripcion" => ($this->input->post('descripcion') != '') ? $this->input->post('descripcion') : null,
                    "porcentaje" => $porcentaje,
                    "fecha_inicio" => ($this->input->post('fecha_inicio') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_inicio'))) : null,
                    "fecha_finaliza" => ($this->input->post('fecha_finaliza') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_finaliza'))) : null,
                );

                $oferta_general_id = $this->oferta_general_model->insert($data_oferta_general);

                foreach ($productos_ids as $producto) {
                    $producto_obj = $this->producto_model->get($producto);
                    if ($porcentaje == 0) {
                        $nuevo_costo = $this->input->post('valor');
                    } else {
                        $monto_a_deducir = $producto_obj->precio * ($porcentaje / 100);
                        $nuevo_costo = $producto_obj->precio - $monto_a_deducir;
                    }

                    $data_oferta = array(
                        "oferta_general_id" => $oferta_general_id,
                        "producto_id" => $producto,
                        "nuevo_costo" => $nuevo_costo
                    );

                    $this->oferta_model->insert($data_oferta);
                }

                foreach ($clientes_ids as $cliente) {
                    $data_grupo = array(
                        "cliente_id" => $cliente,
                        "oferta_general_id" => $oferta_general_id
                    );
                    $this->grupo_oferta_model->insert($data_grupo);
                }

                $this->session->unset_userdata('pv_ofertas_incluir_ids_clientes');
                $this->session->unset_userdata('pv_ofertas_incluir_ids_productos');
                redirect('panel_vendedor/ofertas/ver-oferta/' . $oferta_general_id);
            }
        }
    }

    public function ver_oferta($oferta_general_id) {
        $oferta_general = $this->oferta_general_model->get($oferta_general_id);
        if ($oferta_general) {
            if ($this->oferta_general_model->get_vendedor($oferta_general_id) == $this->identidad->get_vendedor_id()) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $data = array("oferta_general" => $oferta_general);
                $this->template->add_js("modules/admin/panel_vendedores/ofertas_editar.js");
                $this->template->load_view('admin/panel_vendedores/ofertas/oferta_editar', $data);
            } else {
                redirect('panel_vendedor/ofertas/listado');
                // TODO: Accesando una oferta que no es tuya
            }
        } else {
            redirect('panel_vendedor/ofertas/listado');
        }
    }

    public function modificar_clientes($oferta_general_id) {
        $oferta_general = $this->oferta_general_model->get($oferta_general_id);
        if ($oferta_general) {
            if ($this->oferta_general_model->get_vendedor($oferta_general_id) == $this->identidad->get_vendedor_id()) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $data = array("oferta_general" => $oferta_general);
                $this->session->unset_userdata('pv_ofertas_incluir_ids_productos');
                $this->session->unset_userdata('pv_ofertas_incluir_ids_clientes');
                $this->template->add_js("modules/admin/panel_vendedores/ofertas_editar_clientes.js");
                $this->template->load_view('admin/panel_vendedores/ofertas/oferta_editar_clientes', $data);
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
            if ($this->oferta_general_model->get_vendedor($oferta_general_id) == $this->identidad->get_vendedor_id()) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $data = array("oferta_general" => $oferta_general);
                $this->session->unset_userdata('pv_ofertas_incluir_ids_productos');
                $this->session->unset_userdata('pv_ofertas_incluir_ids_clientes');
                $this->template->add_js("modules/admin/panel_vendedores/ofertas_editar_productos.js");
                $this->template->load_view('admin/panel_vendedores/ofertas/oferta_editar_productos', $data);
            } else {
                redirect('panel_vendedor/ofertas/listado');
                // TODO: Accesando una tarifa que no es tuya
            }
        } else {
            redirect('panel_vendedor/ofertas/listado');
        }
    }

    public function modificar_datos($oferta_general_id) {
        $oferta_general = $this->oferta_general_model->get($oferta_general_id);
        if ($oferta_general) {
            if ($this->oferta_general_model->get_vendedor($oferta_general_id) == $this->identidad->get_vendedor_id()) {
                $formValues = $this->input->post();
                if ($formValues !== false) {
                    
                    $data_oferta_general = array(
                        "nombre" => ($this->input->post('nombre') != '') ? $this->input->post('nombre') : null,
                        "descripcion" => ($this->input->post('descripcion') != '') ? $this->input->post('descripcion') : null,                        
                        "fecha_inicio" => ($this->input->post('fecha_inicio') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_inicio'))) : null,
                        "fecha_finaliza" => ($this->input->post('fecha_finaliza') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_finaliza'))) : null,
                    );

                    $this->oferta_general_model->update($oferta_general_id,$data_oferta_general);
                    redirect('panel_vendedor/ofertas/ver-oferta/'.$oferta_general->id);
                } else {
                    $this->template->set_title("Panel de Control - Mercabarato.com");
                    $this->template->set_layout('panel_vendedores');
                    $data = array("oferta_general" => $oferta_general);
                    $this->template->add_js("modules/admin/panel_vendedores/ofertas_editar_datos.js");
                    $this->template->load_view('admin/panel_vendedores/ofertas/oferta_editar_datos', $data);
                }
            } else {
                redirect('panel_vendedor/ofertas/listado');
                // TODO: Accesando una oferta que no es tuya
            }
        } else {
            redirect('panel_vendedor/ofertas/listado');
        }
    }
    
    
    
    

}
