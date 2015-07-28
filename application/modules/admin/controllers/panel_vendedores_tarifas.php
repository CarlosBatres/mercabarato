<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Panel_vendedores_tarifas extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();
        $this->_validar_vendedor_habilitado();
    }

    /**
     * 
     */
    public function nueva_tarifa_paso1() {
        $paquete = $this->vendedor_model->get_paquete_en_curso($this->identidad->get_vendedor_id());

        if ($paquete) {
            if ($paquete->limite_productos != "0") {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $this->template->add_js("modules/admin/panel_vendedores/tarifa_listado_productos.js");

                $this->session->unset_userdata('pv_tarifas_incluir_ids_productos');

                $this->template->load_view('admin/panel_vendedores/tarifas/listado_productos');
            } else {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $this->template->load_view('admin/panel_vendedores/producto/producto_limite');
            }
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
        $paquete = $this->vendedor_model->get_paquete_en_curso($this->identidad->get_vendedor_id());

        if ($paquete) {
            if ($paquete->limite_productos != "0") {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $this->template->add_js("modules/admin/panel_vendedores/tarifa_listado_clientes.js");
                $this->session->unset_userdata('pv_tarifas_incluir_ids_clientes');
                $this->template->load_view('admin/panel_vendedores/tarifas/listado_clientes');
            } else {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $this->template->load_view('admin/panel_vendedores/producto/producto_limite');
            }
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->set_layout('panel_vendedores');
            $this->template->load_view('admin/panel_vendedores/producto/producto_limite');
        }
    }

    /**
     * 
     */
    public function detalles_tarifa() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->set_layout('panel_vendedores');

        $ids_clientes = $this->session->userdata('pv_tarifas_incluir_ids_clientes');
        $ids_productos = $this->session->userdata('pv_tarifas_incluir_ids_productos');

        if ($ids_clientes && $ids_productos) {
            $productos_seleccionados = $ids_productos;
            $mas_de_uno = false;
            if ($productos_seleccionados) {
                if (sizeof($productos_seleccionados) > 1) {
                    $mas_de_uno = true;
                }
            }

            $this->template->add_js("modules/admin/panel_vendedores/tarifa_detalles.js");
            $this->template->load_view('admin/panel_vendedores/tarifas/detalles_tarifa', array("mas_de_uno" => $mas_de_uno));
        } else {
            redirect('panel_vendedor');
        }
    }

    /**
     * 
     */
    public function view_listado() {
        $paquete = $this->vendedor_model->get_paquete_en_curso($this->identidad->get_vendedor_id());

        if ($paquete) {
            if ($paquete->limite_productos != "0") {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');

                $this->template->add_js("modules/admin/panel_vendedores/tarifa_listado.js");
                $categorias = $this->categoria_model->get_all();
                $data = array("categorias" => $categorias);
                $this->template->load_view('admin/panel_vendedores/tarifas/listado', $data);
            } else {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $this->template->load_view('admin/panel_vendedores/producto/producto_limite');
            }
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
            $tarifa_id = $id;

            $res = $this->tarifa_general_model->get_vendedor_id_de_tarifa($tarifa_id);
            if ($res == $this->identidad->get_vendedor_id()) {
                $this->tarifa_general_model->delete($tarifa_id);
                $this->session->set_flashdata('success', 'Tarifa eliminada con exito..');
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
    public function crear_tarifa() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');
            if ($accion === "item-crear") {

                $productos_ids = $this->session->userdata('pv_tarifas_incluir_ids_productos');
                $clientes_ids = $this->session->userdata('pv_tarifas_incluir_ids_clientes');

                if ($this->input->post('tipo') == 'porcentaje') {
                    $porcentaje = $this->input->post('valor');
                } else {
                    $porcentaje = 0;
                }

                $data_tarifa_general = array(
                    "nombre" => ($this->input->post('nombre') != '') ? $this->input->post('nombre') : null,
                    "descripcion" => ($this->input->post('descripcion') != '') ? $this->input->post('descripcion') : null,
                    "porcentaje" => $porcentaje,
                    "fecha_creado" => date("Y-m-d")
                );

                $tarifa_general_id = $this->tarifa_general_model->insert($data_tarifa_general);

                foreach ($productos_ids as $producto) {
                    $producto_obj = $this->producto_model->get($producto);
                    if ($porcentaje == 0) {
                        $nuevo_costo = $this->input->post('valor');
                    } else {
                        $monto_a_deducir = $producto_obj->precio * ($porcentaje / 100);
                        $nuevo_costo = $producto_obj->precio - $monto_a_deducir;
                    }

                    $data_tarifa = array(
                        "tarifa_general_id" => $tarifa_general_id,
                        "producto_id" => $producto,
                        "nuevo_costo" => $nuevo_costo
                    );

                    $this->tarifa_model->insert($data_tarifa);
                }

                foreach ($clientes_ids as $cliente) {
                    $data_grupo = array(
                        "cliente_id" => $cliente,
                        "tarifa_general_id" => $tarifa_general_id
                    );
                    $this->grupo_tarifa_model->insert($data_grupo);
                }

                $this->session->unset_userdata('pv_tarifas_incluir_ids_clientes');
                $this->session->unset_userdata('pv_tarifas_incluir_ids_productos');
                redirect('panel_vendedor/tarifas/ver-tarifa/' . $tarifa_general_id);
            }
        }
    }

    /**
     * Editar Tarifa General
     * @param type $tarifa_general_id
     */
    public function ver_tarifa($tarifa_general_id) {
        $tarifa_general = $this->tarifa_general_model->get($tarifa_general_id);
        if ($tarifa_general) {
            if ($this->tarifa_general_model->get_vendedor($tarifa_general_id) == $this->identidad->get_vendedor_id()) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $data = array("tarifa_general" => $tarifa_general);
                $this->template->add_js("modules/admin/panel_vendedores/tarifa_editar.js");
                $this->template->load_view('admin/panel_vendedores/tarifas/tarifa_editar', $data);
            } else {
                redirect('panel_vendedor/tarifas/listado');
                // TODO: Accesando una tarifa que no es tuya
            }
        } else {
            redirect('panel_vendedor/tarifas/listado');
        }
    }

    public function modificar_clientes($tarifa_general_id) {
        $tarifa_general = $this->tarifa_general_model->get($tarifa_general_id);
        if ($tarifa_general) {
            if ($this->tarifa_general_model->get_vendedor($tarifa_general_id) == $this->identidad->get_vendedor_id()) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $data = array("tarifa_general" => $tarifa_general);
                $this->session->unset_userdata('pv_tarifas_incluir_ids_productos');
                $this->session->unset_userdata('pv_tarifas_incluir_ids_clientes');
                $this->template->add_js("modules/admin/panel_vendedores/tarifa_editar_clientes.js");
                $this->template->load_view('admin/panel_vendedores/tarifas/tarifa_editar_clientes', $data);
            } else {
                redirect('panel_vendedor/tarifas/listado');
                // TODO: Accesando una tarifa que no es tuya
            }
        } else {
            redirect('panel_vendedor/tarifas/listado');
        }
    }

    public function modificar_productos($tarifa_general_id) {
        $tarifa_general = $this->tarifa_general_model->get($tarifa_general_id);
        if ($tarifa_general) {
            if ($this->tarifa_general_model->get_vendedor($tarifa_general_id) == $this->identidad->get_vendedor_id()) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->set_layout('panel_vendedores');
                $data = array("tarifa_general" => $tarifa_general);
                $this->session->unset_userdata('pv_tarifas_incluir_ids_productos');
                $this->session->unset_userdata('pv_tarifas_incluir_ids_clientes');
                $this->template->add_js("modules/admin/panel_vendedores/tarifa_editar_productos.js");
                $this->template->load_view('admin/panel_vendedores/tarifas/tarifa_editar_productos', $data);
            } else {
                redirect('panel_vendedor/tarifas/listado');
                // TODO: Accesando una tarifa que no es tuya
            }
        } else {
            redirect('panel_vendedor/tarifas/listado');
        }
    }

}
