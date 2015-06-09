<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Crear un nuevo cliente     
     * POST
     */
    public function crear() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $password = $this->input->post('password');
            $username = $this->input->post('email');

            $user_id = $this->authentication->create_user($username, $password);

            if ($user_id !== FALSE) {
                $ip_address = $this->session->userdata('ip_address');
                $usuario = $this->usuario_model->get($user_id);
                $usuario->ip_address = $ip_address;
                $usuario->fecha_creado = date("Y-m-d H:i:s");
                $usuario->ultimo_acceso = date("Y-m-d H:i:s");
                $usuario->activo = 1;
                $usuario->is_admin = 0;

                $this->usuario_model->update($user_id,$usuario);

                $data = array(
                    "usuario_id" => $user_id,
                    "nombres" => $this->input->post('nombres'),
                    "apellidos" => $this->input->post('apellidos'),
                    "sexo" => $this->input->post('sexo'),
                    "fecha_nacimiento" => date("Y-m-d", strtotime($this->input->post('fecha_nacimiento'))),
                    "codigo_postal" => $this->input->post('codigo_postal'),
                    "direccion" => $this->input->post('direccion'),
                    "telefono_fijo" => $this->input->post('telefono_fijo'),
                    "telefono_movil" => $this->input->post('telefono_movil'),                    
                    );

                $this->cliente_model->insert($data);
                
                $this->authentication->login($username, $password);
                redirect('');
            } else {
                // There was an ERROR creating the user
                redirect('');
            }
        }else{
            redirect('');
        }
    }
    
}

