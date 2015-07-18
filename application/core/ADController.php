<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class ADController extends MY_Controller {

    var $module;
    var $class;
    var $method;
    var $usuario;

    public function __construct() {
        parent::__construct();
        $this->module = $this->router->fetch_module();
        $this->class = $this->router->fetch_class();
        $this->method = $this->router->fetch_method();

        $user_id = $this->authentication->read('identifier');
        $this->usuario = $this->usuario_model->get($user_id);
    }

    /**
     * Verifico si es una conexion valida al panel de vendedores
     * - Es Vendedor
     * - Existe una sesion iniciada
     */
    public function _validar_conexion() {
        if ($this->authentication->is_loggedin()) {
            if ($this->permisos_model->usuario_es_cliente($this->usuario->id)) {
                if (!$this->_validar_acceso()) {
                    redirect('acceso_restringido');
                }
            } else {
                if ($this->class == "main" && $this->method == "acceso_restringido") {
                    return false;
                } else if (!$this->_validar_acceso()) {
                    redirect('admin/acceso_restringido');
                }
            }
        } else {
            if (strpos($this->class, 'panel_vendedores') !== false) {
                if ($this->uri->uri_string() != 'panel_vendedor/login') {
                    redirect('panel_vendedor/login');
                }
            } else {
                if ($this->uri->uri_string() != 'admin/login') {
                    redirect('admin/login');
                }
            }
        }
    }

    /**
     * 
     * @return boolean
     */
    public function _validar_acceso() {
        $user_id = $this->authentication->read('identifier');
        $perfil = $this->usuario_model->get($user_id);
        $permiso = $this->permisos_model->get($perfil->permisos_id);
        if ($permiso) {
            $perm_array = json_decode($permiso->controllers);
            if (property_exists($perm_array, $this->module)) {
                $temp = $this->module;
                $module = $perm_array->$temp;
                if (property_exists($module, "ALL")) {
                    return true;
                } else if (property_exists($module, $this->class)) {
                    $temp_2 = $this->class;
                    if ($module->$temp_2 == "*") {
                        return true;
                    } else if ($module->$temp_2 == $this->method) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

}
