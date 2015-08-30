<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends MY_Controller {

    public function index() {
        $this->template->set_title('Mercabarato - Busca y Compara');        
        $this->template->add_js('modules/home/inicio.js');
        $this->template->load_view('home/index');
    }
    
    public function productos($search_query){
        $this->session->set_userdata(array('search_query' => $search_query));
        redirect('productos');
    }

    public function not_found() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/404');
    }

    public function acceso_restringido() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/acceso_restringido');
    }

    public function verificar_palabra() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $word = $this->input->post('nombre');
                if (blacklisted_words($word)) {
                    echo json_encode(FALSE);
                } else {
                    echo json_encode(TRUE);
                }
            }
        } else {
            show_404();
        }
    }

    public function verificar_nickname() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $word = strtolower($this->input->post('nombre'));
                if (blacklisted_words($word)) {
                    echo json_encode(FALSE);
                } else {
                    $user_nick = $this->usuario_model->get_by("nickname", $word);
                    if ($user_nick) {
                        echo json_encode(FALSE);
                    } else {
                        $regex = '/[^a-zA-Z0-9_-]/';
                        if (preg_match($regex, $word)) {
                            echo json_encode(FALSE);
                        } else {
                            echo json_encode(TRUE);
                        }
                    }
                }
            }
        } else {
            show_404();
        }
    }

    public function contacto() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->add_js('modules/home/contacto.js');
        $this->template->load_view('home/paginas/contacto');
    }

    public function contacto_submit() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $email = $this->input->post('email');
            $mensaje = $this->input->post('mensaje');

            if ($this->config->item('emails_enabled')) {
                $this->load->library('email');
                $this->email->from($this->config->item('site_info_email'), 'Formulario de Contacto');
                $this->email->to($this->config->item('site_info_email'));

                $this->email->subject('Nuevo mensaje desde Mercabarato.com');
                $data_email = array("email" => $email, "mensaje" => $mensaje);
                $this->email->message($this->load->view('home/emails/contacto', $data_email, true));
                $this->email->send();
            }
        }

        $this->template->load_view('home/paginas/contacto_mensaje_recibido');
    }

    public function quienes_somos() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/quienes_somos');
    }

    public function como_funciona() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/como_funciona');
    }

    public function aviso_legal() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/aviso_legal');
    }

    public function terminos_de_uso() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/terminos_de_uso');
    }

    public function cookies() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/cookies');
    }

    public function test_url() {
        $paquete = $this->vendedor_paquete_model->get("3919");
        $data_email = array("paquete" => $paquete);
        $this->load->view('home/emails/informacion_de_compra', $data_email);
    }
    
    public function busca_compara() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/busca_compara');
    }
    
    public function infocompras() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/infocompras');
    }
    
    public function tarifas_personales() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/tarifas_personales');
    }
    
    public function ventajas_vendedor() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/ventajas_vendedor');
    }

}
