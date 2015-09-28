<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
//require APPPATH . '/libraries/REST_Controller.php';

class main extends REST_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     *  Retornar Categorias e IDS
     */
    function categorias_get() {
        $user_id = $this->get_user_id();
        $vendedor = $this->usuario_model->get_full_identidad($user_id);
        if ($vendedor->es_vendedor_habilitado()) {
            $categorias = $this->categoria_model->get_categorias_webservice();
            $this->response(array('categorias' => $categorias));
        } else {
            $this->response(array('estado' => 'error', 'error' => 'No tienes privilegios para realizar esta operacion'), 404);
        }
    }

    /**
     * Webservice para subir productos en BULK
     */
    function upload_products_post() {
        $this->load->library('image_lib');
        $user_id = $this->get_user_id();
        $vendedor = $this->usuario_model->get_full_identidad($user_id);
        $datos = $this->_post_args;

        $productos_array = array();
        $error_validacion_campos = false;
        $error_array = array();

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
                                    'descripcion' => (!is_array($prod["descripcion"])) ? $prod["descripcion"] : null,
                                    'precio' => $prod["precio"],
                                    'categoria_id' => $prod["categoria_id"],
                                    'mostrar_precio' => $prod["mostrar_precio"],
                                    'mostrar_producto' => $prod["mostrar_producto"],
                                    'habilitado' => $prod["habilitado"],
                                    'link_externo' => (!is_array($prod["link_externo"])) ? $prod["link_externo"] : null,
                                    'vendedor_id' => $vendedor->get_vendedor_id(),
                                );
                                $producto_id = $this->producto_model->insert($data);

                                //**************************************************//
                                // Verificamos si se enviaron imagenes y las subirmos
                                //**************************************************//

                                if (isset($prod["imagen_principal"]) && isset($prod["imagen_principal_extension"])) {
                                    $filename = $this->_crear_imagen($prod["imagen_principal"], $prod["imagen_principal_extension"]);
                                    if ($filename) {
                                        $data_img = array(
                                            "producto_id" => $producto_id,
                                            "nombre" => "Producto: " . $prod["nombre"],
                                            "descripcion" => "Imagen principal del producto " . $prod["nombre"],
                                            "tipo" => "imagen_principal",
                                            "filename" => $filename,
                                            "orden" => 0,
                                        );
                                        $this->producto_resource_model->insert($data_img);
                                    }
                                }
                                $keycc=1;
                                if (isset($prod["imagen_extra1"]) && isset($prod["imagen_extra1_extension"])) {
                                    $filename = $this->_crear_imagen($prod["imagen_extra1"], $prod["imagen_extra1_extension"]);
                                    if ($filename) {
                                        $data_img = array(
                                            "producto_id" => $producto_id,
                                            "nombre" => "Producto: " . $prod["nombre"],
                                            "descripcion" => "Imagen del producto " . $prod["nombre"],
                                            "tipo" => "imagen_alternativas",
                                            "filename" => $filename,
                                            "orden" => $keycc,
                                        );
                                        $keycc++;
                                        $this->producto_resource_model->insert($data_img);
                                    }
                                }

                                if (isset($prod["imagen_extra2"]) && isset($prod["imagen_extra2_extension"])) {
                                    $filename = $this->_crear_imagen($prod["imagen_extra2"], $prod["imagen_extra2_extension"]);
                                    if ($filename) {
                                        $data_img = array(
                                            "producto_id" => $producto_id,
                                            "nombre" => "Producto: " . $prod["nombre"],
                                            "descripcion" => "Imagen del producto " . $prod["nombre"],
                                            "tipo" => "imagen_alternativas",
                                            "filename" => $filename,
                                            "orden" => $keycc,
                                        );
                                        $this->producto_resource_model->insert($data_img);
                                    }
                                }

                                //**************************************************//
                                //**************************************************/

                                $cantidad = $this->vendedor_model->get_cantidad_productos_disp($vendedor->get_vendedor_id());
                            } else {
                                $error_array[] = array("tipo" => "Limite Alcanzado", "datos" => "Producto no insertado : " . $prod["nombre"]);
                            }
                        } else {
                            $error_array[] = array("tipo" => "categoria_id=" . $prod["categoria_id"] . " no existe", "datos" => "Producto no insertado : " . $prod["nombre"]);
                        }
                    }

                    $success = array('estado' => 'completado', 'completado' => 'Operacion completada con exito.');
                    if (sizeof($error_array) > 0) {
                        $success["completado"] = "Operacion completada con algunos errores.";
                        $success["extra"] = $error_array;
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
     * Version local del categorias_get para ser ejecutado desde el server
     */
    function categorias_local_get() {
        $this->categorias_get();
    }

    /**
     * Version local de upload_productos_post para ser ejecutado desde el server ( Panel de Vendedores )
     */
    function upload_products_local_post() {
        $this->_get_basic_auth_data();
        $user = $this->usuario_model->get_by("email", $this->username_c);

        if ($user) {
            $this->set_user_id($user->id);
            $this->upload_products_post();
        } else {
            $this->response(array('estado' => 'error', 'error' => 'No estas Autorizado'), 404);
        }
    }

    /**
     * Pagina principal INDEX
     */
    function index_get() {
        $this->template->set_title('Mercabarato.com - WEBSERVICE');
        $this->template->load_view('webservice/index');
    }    

    /**
     * Validar campos
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
    /**
     * 
     * @param type $img_data
     * @param type $img_ext
     * @return string|boolean
     */
    private function _crear_imagen($img_data, $img_ext) {
        $imagen = base64_decode($img_data);
        if ($img_ext == "jpg" || $img_ext == "png" || $img_ext == "gif" || $img_ext == "jpeg") {
            $filename = md5(time() . rand()) . "." . $img_ext;
            file_put_contents("assets/uploads/temporal/" . $filename, $imagen);

            if (@is_array(getimagesize("assets/uploads/temporal/" . $filename))) {                
                $config['image_library'] = 'gd2';
                $config['source_image'] = "assets/uploads/temporal/" . $filename;
                $config['create_thumb'] = TRUE;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 100;
                $config['height'] = 100;
                $config['thumb_marker'] = '';
                $config['new_image'] = "assets/uploads/productos/thumbnail/" . $filename;
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    //$error_array[] = $this->image_lib->display_errors();
                    return false;
                }
                $this->image_lib->clear();

                $config['image_library'] = 'gd2';
                $config['source_image'] = "assets/uploads/temporal/" . $filename;
                $config['maintain_ratio'] = TRUE;
                $config['width'] = 500;
                $config['height'] = 500;
                $config['new_image'] = "assets/uploads/productos/" . $filename;
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
                    //$error_array[] = $this->image_lib->display_errors();
                    return false;
                }
                $this->image_lib->clear();

                unlink('assets/uploads/temporal/'.$filename);
                return $filename;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}
