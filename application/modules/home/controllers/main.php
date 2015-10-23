<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends MY_Controller {

    protected $spam_protection = TRUE; // true or false
    protected $spam_question = 'Cuanto es 2 + 3?';
    protected $spam_answer = '5';

    /**
     * 
     */
    public function index() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->add_js('modules/home/inicio.js');
        $provincias = $this->provincia_model->get_all_by_pais(70);
        $this->template->load_view('home/index', array("provincias" => $provincias));
    }

    /**
     * 
     */
    public function productos() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $data = array(
                "search_query" => $this->input->post('search_query'),
                "provincia" => $this->input->post('provincia'),
                "poblacion" => $this->input->post('poblacion'),
                "precio_desde" => $this->input->post('precio_desde'),
                "precio_hasta" => $this->input->post('precio_hasta'),
            );

            $this->session->set_userdata(array('search_query_data' => $data));
            redirect('productos');
        }
    }

    /**
     * 
     */
    public function not_found() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/404');
    }

    /**
     * 
     */
    public function acceso_restringido() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/acceso_restringido');
    }

    /**
     * 
     */
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

    /**
     * 
     */
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
                        if (!is_numeric($word)) {
                            $regex = '/^[a-zA-Z0-9_-]+$/';
                            if (preg_match($regex, $word)) {
                                echo json_encode(TRUE);
                            } else {
                                echo json_encode(FALSE);
                            }
                        }else{
                            echo json_encode(FALSE);
                        }
                    }
                }
            }
        } else {
            show_404();
        }
    }

    /**
     * 
     */
    public function contacto() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->add_js('modules/home/contacto.js');
        $data = array(
            "spam_protection" => $this->spam_protection,
            "spam_question" => $this->spam_question,
        );
        $this->template->load_view('home/paginas/contacto', $data);
    }

    /**
     * 
     */
    public function contacto_submit() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $email = $this->input->post('el_email');
            $mensaje = $this->input->post('mensaje');
            $anwser = $this->input->post('spam_anwser');

            $honey_pot = $this->input->post('email');

            if ($honey_pot == "") {
                if (strtolower(trim($anwser)) == strtolower(trim($this->spam_answer))) {
                    if ($this->config->item('emails_enabled')) {
                        $this->load->library('email');
                        $this->email->initialize($this->config->item('email_info'));
                        $this->email->from($this->config->item('site_info_email'), 'Formulario de Contacto');
                        $this->email->to($this->config->item('site_info_email'));
                        $this->email->subject('Nuevo mensaje desde Mercabarato.com');
                        $data_email = array("email" => $email, "mensaje" => $mensaje);
                        $this->email->message($this->load->view('home/emails/contacto', $data_email, true));
                        $this->email->send();
                    }
                    redirect('site/contacto/mensaje-enviado');
                } else {
                    $this->session->set_flashdata("error", "No ingresaste la respuesta correcta.");
                    redirect('site/contacto');
                }
            } else {
                // TODO: OJO POSIBLE BOT!!!!!!
                redirect('');
            }
        }
    }

    /**
     * 
     */
    public function contacto_enviado() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/contacto_mensaje_recibido');
    }

    /**
     * 
     */
    public function quienes_somos() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/quienes_somos');
    }

    /**
     * 
     */
    public function como_funciona() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/como_funciona');
    }

    /**
     * 
     */
    public function aviso_legal() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/aviso_legal');
    }

    /**
     * 
     */
    public function terminos_de_uso() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/terminos_de_uso');
    }

    /**
     * 
     */
    public function cookies() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->load_view('home/paginas/cookies');
    }

    /**
     * 
     */
    public function login_auth() {
        $data = $this->input->get(null, TRUE);
        if ($data) {
            if (isset($data["email"])) {
                if (isset($data["continue"])) {
                    $url_redirect = $data["continue"];

                    // Neceistamos algo especial para esta parte porque el base64 puede contener caracteres no permitidos
                    if (strpos($url_redirect, 'panel_vendedor/producto/responder-mensaje') !== false) {
                        $end = end((explode('/', $url_redirect)));
                        $url_redirect = site_url('panel_vendedor/producto/responder-mensaje/' . urlencode($end));
                    }
                } else {
                    $url_redirect = site_url('');
                }

                if ($this->authentication->is_loggedin()) {
                    $user_id = $this->authentication->read('identifier');
                    $usuario = $this->usuario_model->get_full_identidad($user_id);

                    if ($data["email"] == $usuario->usuario->email) {
                        redirect($url_redirect);
                    } else {
                        $this->authentication->logout();
                        $this->template->set_title('Mercabarato - Busca y Compara');
                        $this->template->set_layout('login_auth');
                        $this->template->add_js('modules/home/login_auth.js');
                        $this->template->load_view('home/login_auth', array("email" => $data["email"], "continue" => $url_redirect));
                    }
                } else {
                    $this->template->set_title('Mercabarato - Busca y Compara');
                    $this->template->set_layout('login_auth');
                    $this->template->add_js('modules/home/login_auth.js');
                    $this->template->load_view('home/login_auth', array("email" => $data["email"], "continue" => $url_redirect));
                }
            } else {
                redirect('');
            }
        } else {
            redirect('');
        }
    }

    /**
     * 
     */
    public function test_url() {
        show_404();

        /* $email="emailvendedor@mail.com";        
          $data_email = array(
          "titulo" => "Titulo",
          "comentario" => "Mensaje",
          "identidad" => "Nombre Cliente",
          "registrar" => true,
          "link" => site_url("auth") . '?email=' . $email . '&continue=' . site_url("panel_vendedor/invitaciones/recibidas"),
          );
          echo $this->load->view('home/emails/invitacion_nueva_email_a_vendedor', $data_email, true); */
    }

}
