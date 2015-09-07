<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Producto extends ADController {

    public function __construct() {
        parent::__construct();
        $this->_validar_conexion();        
    }

    /**
     *  Productos / Listado
     */
    public function view_listado() {
        $this->template->set_title("Panel de Control - Mercabarato.com");
        $this->template->add_js("modules/admin/productos_listado.js");
        $categorias = $this->categoria_model->get_all();
        $data = array("categorias" => $categorias);
        $this->template->load_view('admin/producto/listado', $data);
    }

    /**
     * Productos / Crear
     * 
     * 
     */
    public function crear() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            $accion = $this->input->post('accion');

            if ($accion === "producto-crear") {
                $vendedor_id = $this->input->post('vendedor_id');
                $vendedor = $this->vendedor_model->get($vendedor_id);

                if ($vendedor) {
                    $data = array(
                        "nombre" => $this->input->post('nombre'),
                        "descripcion" => $this->input->post('descripcion'),
                        "precio" => $this->input->post('precio'),
                        "mostrar_producto" => $this->input->post('mostrar_producto'),
                        "mostrar_precio" => $this->input->post('mostrar_precio'),
                        "vendedor_id" => $vendedor_id,
                        "categoria_id" => $this->input->post('categoria'),
                    );

                    $producto_id = $this->producto_model->insert($data);

                    if ($this->input->post('file_name') !== "") {
                        $data_img = array(
                            "producto_id" => $producto_id,
                            "nombre" => "Producto: ".$data["nombre"],
                            "descripcion" => "Imagen principal del producto ".$data["nombre"],
                            "tipo" => "imagen_principal",
                            "filename" => $this->input->post('file_name'),
                            "orden" => 0,
                        );

                        $this->producto_resource_model->insert($data_img);
                    }
                    redirect('admin/productos');
                } else {
                    $this->session->set_flashdata('error', 'El vendedor no existe.');
                    redirect('admin/productos/crear');
                }
            } else {
                redirect('admin');
            }
        } else {
            $this->template->set_title("Panel de Control - Mercabarato.com");
            $this->template->add_js("fileupload.js");
            $this->template->add_js("modules/admin/productos.js");
            $categorias = $this->categoria_model->get_all();

            $data = array("categorias" => $categorias);

            $this->template->load_view('admin/producto/nuevo', $data);
        }
    }

    /**
     * Productos / Borrar
     * 
     * @param type $id
     */
    public function borrar($id) {
        if ($this->input->is_ajax_request()) {            
            $this->producto_model->delete($id);           
        }
    }

    /**
     * Productos / Editar
     * @param type $id
     */
    public function editar($id) {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $accion = $this->input->post('accion');

            if ($accion === "producto-editar") {
                $vendedor_id = $this->input->post('vendedor_id');
                $vendedor = $this->vendedor_model->get($vendedor_id);
                $producto_id = $this->input->post('id');

                if ($vendedor) {
                    $data = array(
                        "nombre" => $this->input->post('nombre'),
                        "descripcion" => $this->input->post('descripcion'),
                        "precio" => $this->input->post('precio'),
                        "mostrar_producto" => $this->input->post('mostrar_producto'),
                        "mostrar_precio" => $this->input->post('mostrar_precio'),
                        "vendedor_id" => $vendedor_id,
                        "categoria_id" => $this->input->post('categoria'),
                    );

                    $this->producto_model->update($producto_id,$data);

                    if ($this->input->post('file_name') !== "") {
                        $producto_imagen = $this->producto_resource_model->get_producto_imagen($producto_id);
                        if ($producto_imagen) {
                            $this->producto_resource_model->delete($producto_imagen->id);
                        }

                        $data_img = array(
                            "producto_id" => $producto_id,
                            "nombre" => "Imagen principal del producto",
                            "descripcion" => "Idealmente esta imagen seria lo mas grande posible.",
                            "tipo" => "imagen_principal",
                            "filename" => $this->input->post('file_name'),
                            "orden" => 0,
                        );

                        $this->producto_resource_model->insert($data_img);
                    }

                    $this->session->set_flashdata('success', 'Producto modificado con exito');
                    redirect('admin/productos');
                } else {
                    $this->session->set_flashdata('error', 'El vendedor no existe.');
                    redirect('admin/productos/editar/' . $producto_id);
                }
            } else {
                redirect('admin');
            }
        } else {
            $producto = $this->producto_model->get($id);
            if ($producto) {
                $this->template->set_title("Panel de Control - Mercabarato.com");
                $this->template->add_js("modules/admin/productos.js");
                $categorias = $this->categoria_model->get_all();
                $vendedor = $this->vendedor_model->get($producto->vendedor_id);
                $producto_imagen = $this->producto_resource_model->get_producto_imagen($producto->id);

                $data = array(
                    "categorias" => $categorias,
                    "producto" => $producto,
                    "vendedor" => $vendedor,
                    "producto_imagen" => $producto_imagen);

                $this->template->load_view('admin/producto/editar', $data);
            } else {
                redirect('admin');
            }
        }
    }

    /**
     *  AJAX Productos / Listado
     */
    public function ajax_get_listado_resultados() {        
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('nombre') != "") {
                $params["nombre"] = $this->input->post('nombre');
            }
            if ($this->input->post('categoria') != 0) {
                $params["categoria_id"] = $this->input->post('categoria');
            }
            if ($this->input->post('vendedor') != "") {
                $params["vendedor"] = $this->input->post('vendedor');
            }
            
            $user_id = $this->authentication->read('identifier');            
            $usuario = $this->usuario_model->get($user_id);
            if($usuario->permisos_id=="2"){
              $params["autorizado_por"]=$user_id;   
            }
            
            $restriccion = $this->restriccion_model->get_by("usuario_id", $user_id);
            if ($restriccion) {
                if ($restriccion->pais_id != null) {
                    $params["pais_id"] = $restriccion->pais_id;
                }
                if ($restriccion->provincia_id != null) {
                    unset($params["pais_id"]);
                    $params["provincia_id"] = $restriccion->provincia_id;
                }
                if ($restriccion->poblacion_id != null) {
                    unset($params["pais_id"]);
                    unset($params["provincia_id"]);
                    $params["poblacion_id"] = $restriccion->poblacion_id;
                }
            }
            
            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        $limit = $this->config->item("admin_default_per_page");
        $offset = $limit * ($pagina - 1);
        $productos_array = $this->producto_model->get_admin_search($params, $limit, $offset);
        $flt = (float) ($productos_array["total"] / $limit);
        $ent = (int) ($productos_array["total"] / $limit);
        if ($flt > $ent || $flt < $ent) {
            $paginas = $ent + 1;
        } else {
            $paginas = $ent;
        }        

        if ($productos_array["total"] == 0) {
            $productos_array["productos"] = array();         
        }
        
        $search_params = array(
                "anterior"=>(($pagina-1)<1)?-1:($pagina-1),
                "siguiente"=>(($pagina+1)>$paginas)?-1:($pagina+1),
                "pagina" => $pagina,
                "total_paginas" => $paginas,
                "por_pagina" => $limit,
                "total" => $productos_array["total"],
                "hasta" => ($pagina * $limit < $productos_array["total"]) ? $pagina * $limit : $productos_array["total"],
                "desde" => (($pagina * $limit) - $limit) + 1);
        
        $pagination = build_paginacion($search_params);
        
        $data = array(
            "productos" => $productos_array["productos"],
            "pagination" => $pagination);

        $this->template->load_view('admin/producto/tabla_resultados', $data);
    }

}
