<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

// Load the MX_Controller class
require APPPATH . 'third_party/MX/Controller.php';

class MY_Controller extends MX_Controller {

    private $_ci;

    public function __construct() {
        parent::__construct();

        $this->_ci = & get_instance();
    }
    /**
     * 
     */
    public function show_profiler() {
        $this->output->enable_profiler(TRUE);
    }

    /**
     * Verifico si es una conexion valida al panel de vendedores
     * - Es Vendedor
     * - Existe una sesion iniciada
     */
    public function _validar_conexion() {
        $one_time_login = $this->session->userdata('one_time_login');
        if ($this->authentication->is_loggedin()) {
            if (!$one_time_login && $this->uri->uri_string() != 'panel_vendedor/login') {
                redirect('panel_vendedor/login');
            } elseif (!$this->_usuario_es_vendedor_habilitado()) {
                // TODO: No puedes acceder al panel todavia
                redirect('acceso_invalido');
            }
        } else {
            if ($this->uri->uri_string() != 'panel_vendedor/login') {
                redirect('panel_vendedor/login');
            }
        }
    }

    /**
     * Validar si el usuario actualmente logeado es Vendedor y esta habilitado
     * @return boolean
     */
    public function _usuario_es_vendedor_habilitado() {
        $user_id = $this->authentication->read('identifier');
        return $this->usuario_model->usuario_es_vendedor_habilitado($user_id);
    }        

    /**
     * Load Javascript inside the page's body
     * @access  public
     * @param   string  $script
     */
    public function _load_script($script) {
        if (isset($this->_ci->template) && is_object($this->_ci->template)) {
            // Queue up the script to be executed after the page is completely rendered
            echo <<< JS
<script>
    var CIS = CIS || { Script: { queue: [] } };
    CIS.Script.queue.push(function() { $script });
</script>
JS;
        } else {
            echo '<script>' . $script . '</script>';
        }
    }

}

class Ajax_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('response');
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */