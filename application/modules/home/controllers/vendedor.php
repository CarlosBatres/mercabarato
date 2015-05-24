<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendedor extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Crear nuevo vendedor
     * POST
     */
    public function new_vendedor() {
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
                $usuario->estado = 1;
                $usuario->is_admin = 0;

                $this->usuario_model->update($usuario, $user_id);

                $data = array(
                    "usuario_id" => $user_id,
                    "nombre" => $this->input->post('nombre'),
                    "descripcion" => $this->input->post('descripcion'),
                    "actividad" => $this->input->post('actividad'),
                    "direccion" => $this->input->post('direccion'),
                    "codigo_postal" => $this->input->post('postal'),
                    "telefono1" => $this->input->post('telefono_principal'),
                    "telefono2" => $this->input->post('telefono_secundario'),
                    "sitioweb" => $this->input->post('sitio_web'),
                    );

                $this->vendedor_model->insert($data);
                
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
