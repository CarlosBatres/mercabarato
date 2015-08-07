<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Vista de la pagina del registro
     */
    public function view_registro() {
        if (!$this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $this->template->add_js('modules/home/registro.js');
            $paises = $this->pais_model->get_all();
            //$keywords = keywords_listado();
            $keywords = $this->categoria_model->get_keywords_from_categorias();
            $data = array("paises" => $paises, "keywords" => $keywords);

            $this->template->load_view('home/usuario/registro', $data);
        } else {
            redirect('');
        }
    }

    public function view_registro_exito() {
        if (!$this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $this->template->load_view('home/usuario/registro_exito');
        } else {
            redirect('');
        }
    }

    /**
     * 
     */
    public function view_perfil() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->usuario_model->get_full_identidad($user_id);
            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->cliente->id);
            $localizacion = $this->localizacion_model->get_by("usuario_id", $user_id);

            if ($localizacion) {
                $full_localizacion = $this->localizacion_model->get_full_localizacion($localizacion->id);
            } else {
                $full_localizacion = false;
            }

            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
            //$this->template->add_js('modules/home/perfil.js');
            $this->template->load_view('home/usuario/perfil', array("html_options" => $html_options, "info" => $cliente, "full_localizacion" => $full_localizacion));
        } else {
            redirect('');
        }
    }

    /**
     *  usuario / perfil
     */
    public function view_datos_personales() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $this->template->add_js("fileupload.js");
            $user_id = $this->authentication->read('identifier');
            $usuario = $this->usuario_model->get($user_id);
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
            if ($cliente_es_vendedor) {
                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);
            } else {
                $vendedor = array();
            }

            $keywords = $this->categoria_model->get_keywords_from_categorias();
            $mis_intereses = explode(";", $cliente->keyword);
            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
            $this->template->add_js('modules/home/perfil.js');
            $this->template->load_view('home/usuario/datos_personales', array(
                "usuario" => $usuario,
                "cliente" => $cliente,
                "vendedor" => $vendedor,
                "html_options" => $html_options,
                "keywords" => $keywords,
                "mis_intereses" => $mis_intereses)
            );
        } else {
            redirect('');
        }
    }

    /**
     *  usuario / password
     */
    public function view_password() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);

            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
            $this->template->add_js('modules/home/perfil.js');
            $this->template->load_view('home/usuario/cambio_password', array("html_options" => $html_options));
        } else {
            redirect('');
        }
    }

    /**
     * 
     */
    public function modificar_datos() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');
            if ($accion === "form-editar") {
                $user_id = $this->authentication->read('identifier');
                $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

                $keywords = $this->input->post('keywords');
                if ($keywords) {
                    $keywords_text = '';
                    foreach ($keywords as $key) {
                        $keywords_text.=$key . ';';
                    }
                    $keywords_text = substr($keywords_text, 0, -1);
                } else {
                    $keywords_text = null;
                }


                $data = array(
                    "nombres" => ($this->input->post('nombres') != '') ? $this->input->post('nombres') : null,
                    "apellidos" => ($this->input->post('apellidos') != '') ? $this->input->post('apellidos') : null,
                    "sexo" => ($this->input->post('sexo') != 'X') ? $this->input->post('sexo') : null,
                    "fecha_nacimiento" => ($this->input->post('fecha_nacimiento') != '') ? date("Y-m-d", strtotime($this->input->post('fecha_nacimiento'))) : null,
                    "codigo_postal" => ($this->input->post('codigo_postal') != '') ? $this->input->post('codigo_postal') : null,
                    "direccion" => ($this->input->post('direccion') != '') ? $this->input->post('direccion') : null,
                    "telefono_fijo" => ($this->input->post('telefono_fijo') != '') ? $this->input->post('telefono_fijo') : null,
                    "telefono_movil" => ($this->input->post('telefono_movil') != '') ? $this->input->post('telefono_movil') : null,
                    "keyword" => $keywords_text
                );

                $this->cliente_model->update($cliente->id, $data);

                if ($this->input->post('nombre_empresa')) {
                    $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);

                    if ($this->input->post('file_name') !== "") {
                        $filename = $this->input->post('file_name');
                        $this->vendedor_model->cleanup_image($vendedor->id);
                    } else {
                        $filename = null;
                    }

                    $data_vendedor = array(
                        "nombre" => ($this->input->post('nombre_empresa') != '') ? $this->input->post('nombre_empresa') : null,
                        "descripcion" => ($this->input->post('descripcion') != '') ? $this->input->post('descripcion') : null,
                        "sitio_web" => ($this->input->post('sitio_web') != '') ? $this->input->post('sitio_web') : null,
                        "actividad" => ($this->input->post('actividad') != '') ? $this->input->post('actividad') : null,
                        "nif_cif" => ($this->input->post('nif_cif') != '') ? $this->input->post('nif_cif') : null,
                        "filename" => $filename
                    );
                    $this->vendedor_model->update($vendedor->id, $data_vendedor);
                }

                $this->session->set_flashdata('success', 'Tus datos han sido modificados con exito.');
            }
            redirect('usuario/perfil');
        } else {
            redirect('usuario/perfil');
        }
    }

    /**
     * 
     */
    public function modificar_password() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');
            if ($accion === "form-editar") {
                $user_id = $this->authentication->read('identifier');
                $usuario = $this->usuario_model->get($user_id);

                $password_old = $this->input->post('password_old');
                $password_new = $this->input->post('password_1');

                if (md5($password_old) == $usuario->password) {
                    $this->authentication->change_password($password_new);
                    $this->session->set_flashdata('success', 'Tus contraseña se ha modificado con exito.');
                } else {
                    $this->session->set_flashdata('error', 'La contraseña que ingresaste es incorrecta.');
                }
            }
            redirect('usuario/password');
        } else {
            redirect('usuario/password');
        }
    }

    /**
     * Iniciar session en la pagina
     * POST-AJAX
     */
    public function login() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();

            if ($formValues !== false) {
                $password = $this->input->post('password');
                $username = $this->input->post('email');

                if ($this->authentication->login($username, $password)) {
                    $ip_address = $this->session->userdata('ip_address');
                    $user_id = $this->authentication->read('identifier');
                    $usuario = $this->usuario_model->get($user_id);
                    $usuario->ip_address = $ip_address;
                    $usuario->ultimo_acceso = date("Y-m-d H:i:s");

                    $this->usuario_model->update($user_id, $usuario);
                    echo json_encode(array("success" => "true", "url" => site_url()));
                } else {
                    echo json_encode(array("success" => "false"));
                }
            }
        } else {
            redirect('');
        }
    }

    /**
     * Cerrar la sesion actual
     * 
     */
    public function logout() {
        $this->authentication->logout();
        redirect('');
    }

    /**
     *  Verificar que el email no exista 
     *  AJAX Call
     */
    public function check_email() {
        if ($this->input->is_ajax_request()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                if ($this->usuario_model->email_exists($this->input->post('email'), $this->input->post('ignore_temporal')) == TRUE) {
                    echo json_encode(FALSE);
                } else {
                    echo json_encode(TRUE);
                }
            }
        } else {
            show_404();
        }
    }

    public function verificar_email($secret_key) {
        if ($this->usuario_model->verificar_email($secret_key)) {
            if (!$this->authentication->is_loggedin()) {
                $this->template->set_title('Mercabarato - Busca y Compara');
                $this->template->load_view('home/usuario/registro_completado');
            } else {
                redirect('');
            }
        } else {
            show_404();
        }
    }

    public function olvido_password() {
        if (!$this->authentication->is_loggedin()) {
            $formValues = $this->input->post();
            if ($formValues !== false) {
                $email = $this->input->post('email');
                $secret_key = substr(md5(uniqid(mt_rand(), true)), 0, 30);
                $timelapse = date("Y-m-d H:i:s");

                $usuario = $this->usuario_model->get_by(array("email" => $email));
                if ($usuario && $email != "admin@mail.com") {
                    if ($this->config->item('emails_enabled')) {
                        $this->load->library('email');
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($email);
                        $this->email->subject('Restablecer contraseña de Mercabarato');
                        $data_email = array("secret_key" => $secret_key);
                        $this->email->message($this->load->view('home/emails/cambio_password', $data_email, true));
                        $this->email->send();
                    }

                    $this->usuario_model->update($usuario->id, array("secret_key" => $secret_key, "timelapse" => $timelapse));
                    $this->session->unset_userdata('olvido-password');
                    $this->session->set_userdata(array('olvido-password' => "enviado"));
                    redirect('olvido-password');
                } else {
                    $this->session->set_flashdata("error", "Este email no esta registrado en nuestro sistema.");
                    redirect('olvido-password');
                }
            } else {
                $this->template->set_title('¿Olvidaste tu Contraseña?');
                $this->template->add_js("modules/home/olvido_password.js");

                $enviado = $this->session->userdata('olvido-password');
                $this->session->unset_userdata('olvido-password');

                $data = array("enviado" => $enviado);
                $this->template->load_view('home/usuario/olvido_password', $data);
            }
        } else {
            redirect('');
        }
    }

    public function olvido_cambio_password($secret_key) {
        if (!$this->authentication->is_loggedin()) {
            $user = $this->usuario_model->get_by(array("secret_key" => $secret_key));
            if ($user) {
                $this->template->set_title('¿Olvidaste tu Contraseña?');
                $this->template->add_js("modules/home/olvido_password.js");
                $data = array("key" => $secret_key);
                $this->template->load_view('home/usuario/olvido_cambio_password', $data);
            } else {
                redirect('404');
            }
        } else {
            redirect('');
        }
    }

    public function modificar_password_olvido() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');
            if ($accion === "form-editar") {
                $password_new = $this->input->post('password_1');
                $secret_key = $this->input->post('key');

                $user = $this->usuario_model->get_by(array("secret_key" => $secret_key));
                if ($user) {
                    $now = new DateTime;
                    $ago = new DateTime($user->timelapse);
                    $diff = $now->diff($ago);

                    $diff->w = floor($diff->d / 7);
                    $diff->d -= $diff->w * 7;

                    if ($diff->d < 1) {
                        $this->authentication->change_password($password_new, $user->id);
                        $this->usuario_model->update($user->id,array("secret_key"=>null,"timelapse"=>null));
                        redirect('cambio-password-realizado');
                    } else {
                        $this->usuario_model->update($user->id,array("secret_key"=>null,"timelapse"=>null));
                        redirect('');
                    }
                }                
            }
        } else {
            redirect('404');
        }
    }

    public function cambio_password_realizado() {
        if (!$this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');                    
            $this->template->load_view('home/usuario/olvido_cambio_password_success');
        }
    }

}
