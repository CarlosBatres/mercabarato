<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendedor extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     *  Afiliarse - Paso 1 
     */
    public function view_afiliarse() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            if (!$this->cliente_model->es_vendedor($cliente->id)) {
                $this->session->unset_userdata('afiliacion_cliente');
                $this->session->unset_userdata('afiliacion_vendedor');

                $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
                $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
                $this->template->load_view('home/vendedor/afiliarse', array("cliente" => $cliente, "html_options" => $html_options));
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

    /**
     *  Afiliarse - Recibe Paso 1
     */
    public function cliente_a_vendedor() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            $data = array(
                "cliente_id" => $cliente->id,
                "nombre" => $this->input->post('nombre_empresa'),
                "descripcion" => $this->input->post('descripcion'),
                "actividad" => $this->input->post('actividad'),
                "sitio_web" => $this->input->post('sitio_web'),
                "habilitado" => 0
            );

            $data_cliente = array(
                "direccion" => $this->input->post('direccion'),
                "telefono_fijo" => $this->input->post('telefono_fijo'),
                "telefono_movil" => $this->input->post('telefono_movil')
            );

            $this->session->unset_userdata('afiliacion_cliente');
            $this->session->unset_userdata('afiliacion_vendedor');

            $this->session->set_userdata(array(
                'afiliacion_cliente' => $data_cliente,
                'afiliacion_vendedor' => $data,
            ));

            redirect('usuario/afiliacion-paso2');
        } else {
            redirect('usuario/perfil');
        }
    }

    /**
     *  Afiliarse - Paso 2
     */
    public function view_seleccionar_paquete() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            if (!$this->cliente_model->es_vendedor($cliente->id)) {
                $paquetes = $this->paquete_model->get_paquetes();
                $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);

                $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
                $this->template->load_view('home/vendedor/seleccion_paquete', array("cliente" => $cliente, "paquetes" => $paquetes, "html_options" => $html_options));
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

    /**
     *  Afiliarse - Recibe Paso 2
     * @param type $paquete_id
     */
    public function submit_afiliacion($paquete_id) {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');

            if ($this->paquete_model->validar_paquete($paquete_id)) {
                $user_id = $this->authentication->read('identifier');
                $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

                $data_cliente = $this->session->userdata('afiliacion_cliente');
                $data_vendedor = $this->session->userdata('afiliacion_vendedor');
                $this->cliente_model->update($cliente->id, $data_cliente);

                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);
                if (!$vendedor) {
                    $vendedor_id = $this->vendedor_model->insert($data_vendedor);
                } else {
                    $this->vendedor_model->update($vendedor->id, $data_vendedor);
                    $vendedor_id = $vendedor->id;
                }


                $this->session->unset_userdata('afiliacion_cliente');
                $this->session->unset_userdata('afiliacion_vendedor');

                $paquete = $this->paquete_model->get($paquete_id);

                // TODO : Calcular la fecha a terminar si aplica
                $data = array(
                    "paquete_id" => $paquete_id,
                    "vendedor_id" => $vendedor_id,
                    "fecha_comprado" => date("Y-m-d"),
                    "fecha_terminar" => null,
                    "fecha_aprobado" => null,
                    "referencia" => "",
                    "productos_insertados" => 0,
                    "anuncios_insertados" => 0,
                    "limite_productos" => $paquete->limite_productos,
                    "limite_anuncios" => $paquete->limite_anuncios,
                    "monto_a_cancelar" => $paquete->costo,
                    "aprobado" => 0
                );
                // TODO: Enviar correo a mercabarato con la informacion de compra y enviarle un correo al email del cliente
                $this->vendedor_paquete_model->insert($data);
                redirect('usuario/completado');
            } else {
                redirect('usuario/afiliacion-paso2');
            }
        } else {
            redirect('');
        }
    }

    /**
     * Afiliarse - Completado
     */
    public function view_completado() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
            $this->template->load_view('home/vendedor/completado', array("cliente" => $cliente, "html_options" => $html_options));
        } else {
            redirect('');
        }
    }

    public function mis_paquetes() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);

            $vendedor_paquetes = $this->vendedor_paquete_model->get_paquetes_por_vendedor($vendedor->id);
            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);

            $data = array(
                "cliente" => $cliente,
                "vendedor" => $vendedor,
                "vendedor_paquetes" => $vendedor_paquetes,
                "html_options" => $html_options
            );

            $this->template->load_view('home/vendedor/paquetes', $data);
        } else {
            redirect('');
        }
    }

    public function mis_productos() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);

            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);

            $data = array(
                "cliente" => $cliente,
                "vendedor" => $vendedor,
                "html_options" => $html_options
            );

            $this->template->load_view('home/vendedor/productos', $data);
        } else {
            redirect('');
        }
    }

    public function mis_anuncios() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);

            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);

            $data = array(
                "html_options" => $html_options
            );

            $this->template->load_view('home/vendedor/anuncios', $data);
        } else {
            redirect('');
        }
    }

    public function comprar_paquetes() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            if ($this->cliente_model->es_vendedor($cliente->id)) {
                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);
                $paquetes = $this->paquete_model->get_paquetes();

                $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
                $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);

                $data = array(
                    "html_options" => $html_options,
                    "cliente"=>$cliente,
                    "paquetes"=>$paquetes
                );

                $this->template->load_view('home/vendedor/compra_paquete', $data);
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

    public function submit_comprar_paquetes($paquete_id) {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');

            if ($this->paquete_model->validar_paquete($paquete_id)) {
                $user_id = $this->authentication->read('identifier');
                $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);

                $paquete = $this->paquete_model->get($paquete_id);

                // TODO : Calcular la fecha a terminar si aplica
                $data = array(
                    "paquete_id" => $paquete_id,
                    "vendedor_id" => $vendedor->id,
                    "fecha_comprado" => date("Y-m-d"),
                    "fecha_terminar" => null,
                    "fecha_aprobado" => null,
                    "referencia" => "",
                    "productos_insertados" => 0,
                    "anuncios_insertados" => 0,
                    "limite_productos" => $paquete->limite_productos,
                    "limite_anuncios" => $paquete->limite_anuncios,
                    "monto_a_cancelar" => $paquete->costo,
                    "aprobado" => 0
                );
                // TODO: Enviar correo a mercabarato con la informacion de compra y enviarle un correo al email del cliente
                $this->vendedor_paquete_model->insert($data);
                redirect('usuario/paquetes');
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

}
