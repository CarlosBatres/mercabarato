<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cron_controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     *  Se ejecuta al final de cada dia
     *  Verifico los paquetes que estan por caducar y los inhabilito (vendedor/productos/anuncios)
     */
    public function validar_paquetes() {
        if ($this->input->is_cli_request()) {
            if ($this->config->item('emails_enabled')) {
                $this->load->library('email');
                $this->email->initialize($this->config->item('email_info'));
            }

            $dias_previos_aviso = 10;
            $paquetes_por_vencer = $this->vendedor_paquete_model->get_paquetes_a_caducar($dias_previos_aviso);
            if ($paquetes_por_vencer) {

                foreach ($paquetes_por_vencer as $paquete) {
                    if ($this->config->item('emails_enabled')) {
                        $email = $this->vendedor_model->get_email($paquete->vendedor_id);
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($email);
                        $this->email->subject('Tu paquete esta apunto de caducar');
                        $data_email = array(
                            "paquete" => $paquete,
                            "vendedor" => false,
                            "dias_caducar" => $dias_previos_aviso
                        );
                        $this->email->message($this->load->view('home/emails/paquete_5dias_caducar', $data_email, true));
                        $this->email->send();
                        $this->email->clear();
                        
                        // Enviamos el mensaje al correo de comercial

                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($this->config->item('site_comercial_email'));
                        $this->email->subject('Un paquete esta apunto de caducar');
                        $vendedor = $this->vendedor_model->get($paquete->vendedor_id);

                        $data_email = array(
                            "paquete" => $paquete,
                            "vendedor" => $vendedor->nombre,
                            "dias_caducar" => $dias_previos_aviso
                        );
                        $this->email->message($this->load->view('home/emails/paquete_5dias_caducar', $data_email, true));
                        $this->email->send();
                        $this->email->clear();

                        // Enviamos el mensaje al correo del vendedor administrador siempre y cuando no sea el admin osea 1
                        
                        if ($paquete->autorizado_por != 1) {
                            $vendedor_admin_email = $this->usuario_model->get_email($paquete->autorizado_por);

                            $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                            $this->email->to($vendedor_admin_email);
                            $this->email->subject('Un paquete esta apunto de caducar');
                            $vendedor = $this->vendedor_model->get($paquete->vendedor_id);

                            $data_email = array(
                                "paquete" => $paquete,
                                "vendedor" => $vendedor->nombre,
                                "dias_caducar" => $dias_previos_aviso
                            );
                            $this->email->message($this->load->view('home/emails/paquete_5dias_caducar', $data_email, true));
                            $this->email->send();
                            $this->email->clear();
                        }
                    }
                }
            }

            $paquetes_vencidos = $this->vendedor_paquete_model->get_paquetes_a_caducar();
            if ($paquetes_vencidos) {
                foreach ($paquetes_vencidos as $paquete) {
                    $this->vendedor_paquete_model->paquete_vencido($paquete->id);
                    if ($this->config->item('emails_enabled')) {
                        $renovacion = $this->vendedor_model->get_paquete_renovacion($paquete->vendedor_id);
                        if (!$renovacion) {
                            $email = $this->vendedor_model->get_email($paquete->vendedor_id);
                            $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                            $this->email->to($email);
                            $this->email->subject('Tu paquete a caducado');
                            $data_email = array("paquete" => $paquete);
                            $this->email->message($this->load->view('home/emails/paquete_caducado', $data_email, true));
                            $this->email->send();
                            $this->email->clear();
                        }
                    }
                }
            }
        } else {
            redirect('');
        }
    }

    /**
     * Cada 3 dias
     */
    public function productos_novedades() {
        if ($this->input->is_cli_request()) {
            if ($this->config->item('emails_enabled')) {
                $this->load->library('email');
                $this->email->initialize($this->config->item('email_info'));
            }

            $days = 2;
            $date_inicio = strtotime(date('Y-m-d'));
            $date_inicio = strtotime("-" . $days . " day", $date_inicio);
            $date_inicio = date("Y-m-d", $date_inicio);
            $date_final = date("Y-m-d");

            $productos = $this->producto_model->get_novedades_fecha($date_inicio, $date_final, false);

            if ($productos) {
                $data = array();
                /**
                 * Por cada producto busco su vendedor y cada vendedor sus invitados que permitan notificaciones
                 */
                foreach ($productos as $producto) {
                    $vendedor = $this->vendedor_model->get($producto->vendedor_id);
                    $cliente = $this->cliente_model->get($vendedor->cliente_id);

                    $invitados = $this->invitacion_model->get_invitados_notificaciones($cliente->usuario_id);
                    if ($invitados) {
                        if (!isset($data[$vendedor->id])) {
                            $data[$vendedor->id] = $invitados;
                        }
                    }
                }
                /**
                 * Invierto el array para tener Clientes y sus Vendedores conectados
                 */
                $invertir = array();
                if (sizeof($data) > 0) {
                    foreach ($data as $vendedor_id => $ids) {
                        foreach ($ids as $ci) {
                            if (!isset($invertir[$ci])) {
                                $invertir[$ci] = array($vendedor_id);
                            } else {
                                array_push($invertir[$ci], $vendedor_id);
                            }
                        }
                    }
                }
                /**
                 * Por cada cliente busco las novedades en base a sus vendedores conectados
                 */
                if (sizeof($invertir) > 0) {
                    foreach ($invertir as $cliente => $vendedor) {
                        $pros = $this->producto_model->get_novedades_fecha($date_inicio, $date_final, 3, $vendedor);
                        $cliente_email = $this->usuario_model->get_email($cliente);

                        if ($this->config->item('emails_enabled')) {
                            $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                            $this->email->to($cliente_email);
                            $this->email->subject('Novedades en Mercabarato.com');
                            $data_email = array("productos" => $pros);
                            $this->email->message($this->load->view('home/emails/novedades_productos', $data_email, true));
                            $this->email->send();
                            $this->email->clear();
                        }
                    }
                }
            }
        }
    }

    /**
     * Cada dia
     */
    public function infocompras_mensajes() {
        if ($this->input->is_cli_request()) {
            if ($this->config->item('emails_enabled')) {
                $this->load->library('email');
                $this->email->initialize($this->config->item('email_info'));
            }

            $params = array();
            $infocompra = $this->infocompra_model->get_infocompras_por_caducar($params);

            if ($infocompra) {
                foreach ($infocompra as $var) {
                    $vendedor = $this->vendedor_model->get($var->vendedor_id);
                    $email_vendedor = $this->vendedor_model->get_email($vendedor->id);

                    if ($this->config->item('emails_enabled')) {
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($email_vendedor);
                        $this->email->subject('Tienes una solicitud de infocompras a punto de caducar.');
                        $data_email = array();

                        if ($var->solicitud_seguro == "1") {
                            $data_email["link"] = site_url("auth") . '?email=' . $email_vendedor . '&continue=' . site_url("panel_vendedor/infocompras/seguros/responder/") . '/' . $var->infocompra_id;
                        } else if ($var->infocompra_general == "1") {
                            $data_email["link"] = site_url("auth") . '?email=' . $email_vendedor . '&continue=' . site_url("panel_vendedor/infocompras/generales/responder/") . '/' . $var->infocompra_id;
                        }

                        $this->email->message($this->load->view('home/emails/infocompra_caducar_vendedor', $data_email, true));
                        $this->email->send();
                        $this->email->clear();
                    }

                    $cliente = $this->cliente_model->get($var->cliente_id);
                    $email_cliente = $this->cliente_model->get_email($cliente->id);

                    if ($this->config->item('emails_enabled')) {
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($email_cliente);
                        $this->email->subject('Tienes una solicitud de infocompras a punto de caducar.');
                        $data_email = array();

                        if ($var->solicitud_seguro == "1") {
                            $data_email["link"] = site_url("auth") . '?email=' . $email_cliente . '&continue=' . site_url("usuario/infocompras-seguros/extenderla/") . '/' . $var->infocompra_id;
                        } else if ($var->infocompra_general == "1") {
                            $data_email["link"] = site_url("auth") . '?email=' . $email_cliente . '&continue=' . site_url("usuario/infocompras-general/extenderla/") . '/' . $var->infocompra_id;
                        }

                        $this->email->message($this->load->view('home/emails/infocompra_caducar_cliente', $data_email, true));
                        $this->email->send();
                        $this->email->clear();
                    }
                }
            }

            $infocompra = $this->infocompra_model->get_infocompras_caducado($params);

            if ($infocompra) {
                foreach ($infocompra as $var) {
                    $this->infocompra_model->delete($var->infocompra_id);
                }
            }
        }
    }

}
