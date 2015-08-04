<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
//require APPPATH . '/libraries/REST_Controller.php';

class webservice extends REST_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     *  Retornar Categorias e IDS
     */
    function categorias_get() {
        $categorias = $this->categoria_model->get_categorias_webservice();
        $this->response(array('categorias' => $categorias));
    }
    
    /**
     * Webservice para subir productos en BULK
     */
    function upload_products_post() {
        $user_id = $this->get_user_id();
        $vendedor = $this->usuario_model->get_full_identidad($user_id);

        $datos = $this->_post_args;
        $productos_array = array();
        $error_validacion_campos = false;
        $error_array=array();

        if ($vendedor->es_vendedor_habilitado()) {
            if (isset($datos["productos"]["producto"])) {
                // Multi
                if (isset($datos["productos"]["producto"]["0"])) {
                    foreach ($datos["productos"]["producto"] as $producto) {
                        if ($this->_validar_campos($producto)) {
                            $productos_array[] = $producto;
                        } else {
                            $error_validacion_campos = true;
                        }
                    }
                } else {
                    // Single
                    if ($this->_validar_campos($datos["productos"]["producto"])) {
                        $productos_array[] = $datos["productos"]["producto"];
                    } else {
                        $error_validacion_campos = true;
                    }
                }

                if (sizeof($productos_array) > 0) {
                    $cantidad = $this->vendedor_model->get_cantidad_productos_disp($vendedor->get_vendedor_id());
                    foreach ($productos_array as $prod) {
                        $categoria = $this->categoria_model->get($prod["categoria_id"]);
                        if ($categoria) {                            
                            if ($cantidad > 0) {
                                $data = array(
                                    'nombre' => $prod["nombre"],
                                    'descripcion' => (isset($prod["descripcion"])) ? $prod["descripcion"] : null,
                                    'precio' => $prod["precio"],
                                    'categoria_id' => $prod["categoria_id"],
                                    'mostrar_precio' => $prod["mostrar_precio"],
                                    'mostrar_producto' => $prod["mostrar_producto"],
                                    'habilitado' => $prod["habilitado"],
                                    'link_externo' => (isset($prod["link_externo"])) ? $prod["link_externo"] : null,
                                    'vendedor_id' => $vendedor->get_vendedor_id(),
                                );
                                $this->producto_model->insert($data);
                                $cantidad--;
                            }else{                                
                                $error_array[]=array("tipo"=>"Limite Alcanzado","datos"=>"Producto no insertado : ".$prod["nombre"]);
                            }                                                   
                        }else{
                            $error_array[]=array("tipo"=>"Categoria no existe","categoria_id"=>$prod["categoria_id"],"datos"=>"Producto no insertado : ".$prod["nombre"]);                            
                        }
                    }
                    
                    $success=array('estado' => 'completado', 'completado' => 'Operacion completada con exito.');
                    if(sizeof($error_array)>0){
                        $success["completado"]="Operacion completada con algunos errores.";
                        $success["extra"]=$error_array;
                    }
                    $this->response($success);
                } else {
                    $this->response(array('estado' => 'error', 'error' => 'El formato de la peticion es invalido.'), 404);
                }
            } else {
                $this->response(array('estado' => 'error', 'error' => 'El formato de la peticion es invalido.'), 404);
            }
        } else {
            $this->response(array('estado' => 'error', 'error' => 'No tienes privilegios para realizar esta operacion'), 404);
        }        
    }

    /**
     * 
     * @param type $producto
     */
    private function _validar_campos($producto) {
        $flag = true;
        if (!isset($producto["nombre"])) {
            $flag = false;
        }
        if (!isset($producto["precio"])) {
            $flag = false;
        } elseif (!is_numeric($producto["precio"])) {
            $flag = false;
        }
        if (!isset($producto["categoria_id"])) {
            $flag = false;
        }
        if (!isset($producto["mostrar_precio"])) {
            $flag = false;
        } elseif ($producto["mostrar_precio"] != "1" && $producto["mostrar_precio"] != "0") {
            $flag = false;
        }
        if (!isset($producto["mostrar_producto"])) {
            $flag = false;
        } elseif ($producto["mostrar_producto"] != "1" && $producto["mostrar_producto"] != "0") {
            $flag = false;
        }
        if (!isset($producto["habilitado"])) {
            $flag = false;
        } elseif ($producto["habilitado"] != "1" && $producto["habilitado"] != "0") {
            $flag = false;
        }
        return $flag;
    }

}
