<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class ADController extends MY_Controller {

    var $module;
    var $class;
    var $method;
    var $identidad;

    public function __construct() {
        parent::__construct();
        $this->template->add_metadata("robots","none");
        
        $this->module = $this->router->fetch_module();
        $this->class = $this->router->fetch_class();
        $this->method = $this->router->fetch_method();

        $this->get_identidad();
    }

    /**
     * 
     */
    private function get_identidad() {
        $user_id = $this->authentication->read('identifier');
        $vendedor = $this->usuario_model->get_full_identidad($user_id);
        if($vendedor){
            $this->identidad = $vendedor;
        }else{
            $this->identidad = false;
        }
        
    }

    /**
     * Verifico si es una conexion valida al panel de vendedores
     * - Es Vendedor
     * - Existe una sesion iniciada
     */
    public function _validar_conexion() {
        if ($this->authentication->is_loggedin()) {
            if ($this->permisos_model->usuario_es_cliente($this->identidad->usuario->id)) {
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
        //$user_id = $this->authentication->read('identifier');
        //$perfil = $this->usuario_model->get($user_id);

        $permiso = $this->permisos_model->get($this->identidad->usuario->permisos_id);
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

    /**
     * 
     * @return boolean
     */
    public function _validar_vendedor_habilitado() {
        if ($this->identidad) {
            if (!$this->identidad->es_vendedor_habilitado()) {
                redirect('acceso_restringido');
            } else {
                $paquete=$this->vendedor_model->get_paquete_en_curso($this->identidad->vendedor->id);
                if($paquete){
                    return true;
                }else{
                    redirect('acceso_restringido');
                }                
            }
        }
    }

}
