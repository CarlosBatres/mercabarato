<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cron_controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     *  Verifico los paquetes que estan por caducar y los inhabilito (vendedor/productos/anuncios)
     */
    public function validar_paquetes() {
        if ($this->input->is_cli_request()) {
            $dias_previos_aviso = 5;
            $paquetes_por_vencer = $this->vendedor_paquete_model->get_paquetes_a_caducar($dias_previos_aviso);
            if ($paquetes_por_vencer) {
                foreach ($paquetes_por_vencer as $paquete) {
                    if ($this->config->item('emails_enabled')) {
                        $email = $this->vendedor_model->get_email($paquete->vendedor_id);
                        $this->load->library('email');
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($email);
                        $this->email->subject('Tu paquete esta apunto de caducar');
                        $data_email = array("paquete" => $paquete);
                        $this->email->message($this->load->view('home/emails/paquete_5dias_caducar', $data_email, true));
                        $this->email->send();
                    }
                }
            }

            $paquetes_vencidos = $this->vendedor_paquete_model->get_paquetes_a_caducar();
            if ($paquetes_vencidos) {
                foreach ($paquetes_vencidos as $paquete) {
                    $this->vendedor_paquete_model->paquete_vencido($paquete->id);
                    if ($this->config->item('emails_enabled')) {
                        $email = $this->vendedor_model->get_email($paquete->vendedor_id);
                        $this->load->library('email');
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($email);
                        $this->email->subject('Tu paquete a caducado');
                        $data_email = array("paquete" => $paquete);
                        $this->email->message($this->load->view('home/emails/paquete_caducado', $data_email, true));
                        $this->email->send();
                    }
                }
            }
        }else{
            redirect('');
        }
    }
    
    public function test_crons() {
        if ($this->input->is_cli_request()) {
            echo "TESTING";
        }
    }

    public function productos_novedades() {
        $productos = $this->producto_model->get_novedades_fecha("2015-07-1", "2015-07-28");
    }

}
