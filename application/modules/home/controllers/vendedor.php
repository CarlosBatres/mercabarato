<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendedor extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     *  Afiliarse - Paso 1 
     */
    public function view_afiliarse() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $keywords = $this->categoria_model->get_keywords_from_categorias();

            if (!$this->permisos_model->usuario_es_admin($user_id)) {
                if (!$this->cliente_model->es_vendedor($cliente->id)) {
                    $this->session->unset_userdata('afiliacion_cliente');
                    $this->session->unset_userdata('afiliacion_vendedor');
                    $this->session->unset_userdata('afiliacion_localizacion');

                    //$paises = $this->pais_model->get_all();                    
                    $localizacion = $this->localizacion_model->get_by("usuario_id", $cliente->usuario_id);
                    $provincias = $this->provincia_model->get_all_by_pais(70);
                    $poblaciones = array();
                    $provincia_id = 0;
                    $poblacion_id = 0;

                    if ($localizacion) {
                        if ($localizacion->provincia_id != null) {
                            $provincia_id = $localizacion->provincia_id;
                            $poblaciones = $this->poblacion_model->get_all_by_provincia($provincia_id);
                        }
                        if ($localizacion->poblacion_id != null) {
                            $poblacion_id = $localizacion->poblacion_id;
                        }
                    }


                    $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
                    $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
                    $this->template->add_js('modules/home/perfil.js');
                    $this->template->load_view('home/vendedor/afiliarse', array(
                        "cliente" => $cliente,
                        "html_options" => $html_options,
                        "keywords" => $keywords,
                        "provincias" => $provincias,
                        "poblaciones" => $poblaciones,
                        "provincia_id" => $provincia_id,
                        "poblacion_id" => $poblacion_id
                    ));
                } else {
                    redirect('usuario/perfil');
                }
            } else {
                $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
                $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
                $this->template->load_view('home/usuario/no_afiliable', array("cliente" => $cliente, "html_options" => $html_options));
            }
        } else {
            redirect('');
        }
    }

    /**
     *  Afiliarse - Recibe Paso 1
     */
    public function cliente_a_vendedor() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
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

            if ($keywords_text != null) {
                $keyword_id = $this->keyword_model->insert(array("keywords" => $keywords_text));
            } else {
                $keyword_id = null;
            }

            $data = array(
                "cliente_id" => $cliente->id,
                "nombre" => $this->input->post('nombre_empresa'),
                "descripcion" => $this->input->post('descripcion'),
                "actividad" => $this->input->post('actividad'),
                "sitio_web" => $this->input->post('sitio_web'),
                "habilitado" => 0,
                "nif_cif" => $this->input->post('nif_cif'),
                "nickname" => $this->input->post('nickname'),
                "keyword" => $keyword_id
            );

            $data_cliente = array(
                "direccion" => $this->input->post('direccion'),
                "telefono_fijo" => $this->input->post('telefono_fijo'),
                "telefono_movil" => $this->input->post('telefono_movil')
            );

            //$pais = $this->input->post('pais');
            $pais = "70";
            $provincia = $this->input->post('provincia');
            $poblacion = $this->input->post('poblacion');

            if ($pais != "0") {
                $data_localizacion = array(
                    "usuario_id" => $user_id,
                    "pais_id" => $pais,
                    "provincia_id" => ($provincia == "0") ? null : $provincia,
                    "poblacion_id" => ($poblacion == "0") ? null : $poblacion
                );
            } else {
                $data_localizacion = false;
            }

            $data_puntos_venta = array();
            if ($this->input->post('nombre_punto_venta_1') != "") {
                $data_puntos_venta[] = array(
                    "nombre" => $this->input->post('nombre_punto_venta_1'),
                    "direccion" => $this->input->post("direccion_punto_venta_1")
                );
            }
            if ($this->input->post('nombre_punto_venta_2') != "") {
                $data_puntos_venta[] = array(
                    "nombre" => $this->input->post('nombre_punto_venta_2'),
                    "direccion" => $this->input->post("direccion_punto_venta_2")
                );
            }
            if ($this->input->post('nombre_punto_venta_3') != "") {
                $data_puntos_venta[] = array(
                    "nombre" => $this->input->post('nombre_punto_venta_3'),
                    "direccion" => $this->input->post("direccion_punto_venta_3")
                );
            }


            $this->session->unset_userdata('afiliacion_cliente');
            $this->session->unset_userdata('afiliacion_vendedor');
            $this->session->unset_userdata('afiliacion_localizacion');
            $this->session->unset_userdata('afiliacion_puntos_venta');

            $this->session->set_userdata(array(
                'afiliacion_cliente' => $data_cliente,
                'afiliacion_vendedor' => $data,
                'afiliacion_localizacion' => $data_localizacion,
                'afiliacion_puntos_venta' => $data_puntos_venta,
            ));

            redirect('usuario/afiliacion-paso2');
        } else {
            redirect('usuario/perfil');
        }
    }

    /**
     *  Afiliarse - Paso 2
     */
    public function view_seleccionar_paquete() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            if (!$this->cliente_model->es_vendedor($cliente->id)) {
                $paquetes = $this->paquete_model->get_paquetes();
                $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);

                $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
                $this->template->add_js('modules/home/perfil.js');
                $this->template->load_view('home/vendedor/seleccion_paquete', array("cliente" => $cliente, "paquetes" => $paquetes, "html_options" => $html_options));
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

    /**
     *  Afiliarse - Recibe Paso 2
     * @param type $paquete_id
     */
    public function submit_afiliacion($paquete_id) {
        if ($this->authentication->is_loggedin()) {
            $config = array(
                'table' => 'vendedor',
                'id' => 'id',
                'field' => 'unique_slug',
                'title' => 'nombre',
                'replacement' => 'dash' // Either dash or underscore
            );
            $this->load->library('slug', $config);
            $this->template->set_title('Mercabarato - Busca y Compara');

            if ($this->paquete_model->validar_paquete($paquete_id)) {
                $user_id = $this->authentication->read('identifier');
                $usuario = $this->usuario_model->get($user_id);
                $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

                $data_cliente = $this->session->userdata('afiliacion_cliente');
                $data_vendedor = $this->session->userdata('afiliacion_vendedor');
                $data_localizacion = $this->session->userdata('afiliacion_localizacion');
                $data_puntos_venta = $this->session->userdata('afiliacion_puntos_venta');
                $this->cliente_model->update($cliente->id, $data_cliente);
                $nickname = $data_vendedor["nickname"];
                unset($data_vendedor["nickname"]);
                $data_vendedor["unique_slug"] = $this->slug->create_uri($nickname);
                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);
                if (!$vendedor) {
                    $vendedor_id = $this->vendedor_model->insert($data_vendedor);
                } else {
                    $this->vendedor_model->update($vendedor->id, $data_vendedor);
                    $vendedor_id = $vendedor->id;
                }

                $this->usuario_model->update($user_id, array("nickname" => $nickname));

                if ($data_localizacion) {
                    $this->localizacion_model->delete_by("usuario_id", $data_localizacion["usuario_id"]);
                    $this->localizacion_model->insert($data_localizacion);
                }

                if ($data_puntos_venta) {
                    foreach ($data_puntos_venta as $punto) {
                        $this->punto_venta_model->insert(array(
                            "vendedor_id" => $vendedor_id,
                            "nombre" => $punto["nombre"],
                            "direccion" => $punto["direccion"]
                        ));
                    }
                }

                $this->session->unset_userdata('afiliacion_cliente');
                $this->session->unset_userdata('afiliacion_vendedor');
                $this->session->unset_userdata('afiliacion_localizacion');
                $this->session->unset_userdata('afiliacion_puntos_venta');

                $paquete = $this->paquete_model->get($paquete_id);
                $data = array(
                    "vendedor_id" => $vendedor_id,
                    "nombre_paquete" => $paquete->nombre,
                    "duracion_paquete" => $paquete->duracion,
                    "fecha_comprado" => date("Y-m-d"),
                    "fecha_terminar" => null,
                    "fecha_aprobado" => null,
                    "referencia" => "",
                    "limite_productos" => $paquete->limite_productos,
                    "limite_anuncios" => $paquete->limite_anuncios,
                    "monto_a_cancelar" => $paquete->costo,
                    "aprobado" => 0,
                    "infocompra" => $paquete->infocompra
                );

                $result = $this->vendedor_model->verificar_disponibilidad($vendedor->id);

                if ($result) {
                    if ($this->config->item('emails_enabled')) {
                        $this->load->library('email');
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($usuario->email);
                        $this->email->subject('Informacion para pago del paquete');
                        $data_email = array("paquete" => $data);
                        $this->email->message($this->load->view('home/emails/informacion_de_compra', $data_email, true));
                        $this->email->send();

                        $this->load->library('email');
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($this->config->item('site_info_email'));
                        $this->email->subject('Nueva compra de paquete');
                        $data_email = array("paquete" => $data, "vendedor" => $vendedor);
                        $this->email->message($this->load->view('home/emails/nueva_compra_paquete', $data_email, true));
                        $this->email->send();
                    }

                    $this->vendedor_paquete_model->insert($data);
                }

                redirect('usuario/completado');
            } else {
                redirect('usuario/afiliacion-paso2');
            }
        } else {
            redirect('');
        }
    }

    /**
     * Afiliarse - Completado
     */
    public function view_completado() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
            $this->template->load_view('home/vendedor/completado', array("cliente" => $cliente, "html_options" => $html_options));
        } else {
            redirect('');
        }
    }

    public function ir_panel_vendedor() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            if ($this->cliente_model->es_vendedor($cliente->id)) {
                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);

                $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => true), true);

                $data = array(
                    "cliente" => $cliente,
                    "vendedor" => $vendedor,
                    "html_options" => $html_options
                );
                $this->template->add_js('modules/home/perfil.js');
                $this->template->load_view('home/vendedor/pre_panel', $data);
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

    public function mis_paquetes() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            if ($this->cliente_model->es_vendedor($cliente->id)) {
                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);
                $vendedor_paquetes = $this->vendedor_paquete_model->get_paquetes_por_vendedor($vendedor->id);

                $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => true), true);

                $paquete_en_curso = $this->vendedor_model->get_paquete_en_curso($vendedor->id);
                $date = strtotime(date("Y-m-d"));
                $date = strtotime("+5 day", $date);
                $date5 = date('Y-m-d', $date);


                if ($paquete_en_curso) {
                    if ($paquete_en_curso->fecha_terminar <= $date5) {
                        $renovar = true;
                    } else {
                        $renovar = false;
                    }
                } else {
                    $renovar = false;
                }

                $paquete_pendiente = $this->vendedor_model->get_paquete_pendiente($vendedor->id);
                $paquete_renovacion = $this->vendedor_model->get_paquete_renovacion($vendedor->id);
                if ($paquete_pendiente || $paquete_renovacion) {
                    $renovar = false;
                    $nada = true;
                } else {
                    $nada = false;
                }

                $data = array(
                    "cliente" => $cliente,
                    "vendedor" => $vendedor,
                    "vendedor_paquetes" => $vendedor_paquetes,
                    "html_options" => $html_options,
                    "renovar" => $renovar,
                    "date5" => $date5,
                    "nada" => $nada
                );
                $this->template->add_js('modules/home/perfil.js');
                $this->template->load_view('home/vendedor/paquetes', $data);
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

    public function comprar_paquetes() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            if ($this->cliente_model->es_vendedor($cliente->id)) {
                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);
                $paquetes = $this->paquete_model->get_paquetes();

                $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
                $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);

                $puede_comprar = $this->vendedor_model->verificar_disponibilidad($vendedor->id);

                $data = array(
                    "html_options" => $html_options,
                    "cliente" => $cliente,
                    "paquetes" => $paquetes,
                    "puede_comprar" => $puede_comprar
                );
                $this->template->add_js('modules/home/perfil.js');
                $this->template->load_view('home/vendedor/compra_paquete', $data);
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

    public function submit_comprar_paquetes($paquete_id) {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');

            if ($this->paquete_model->validar_paquete($paquete_id)) {
                $user_id = $this->authentication->read('identifier');
                $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);
                $usuario = $this->usuario_model->get($cliente->usuario_id);

                $paquete = $this->paquete_model->get($paquete_id);
                $data = array(
                    "vendedor_id" => $vendedor->id,
                    "nombre_paquete" => $paquete->nombre,
                    "duracion_paquete" => $paquete->duracion,
                    "fecha_comprado" => date("Y-m-d"),
                    "fecha_terminar" => null,
                    "fecha_aprobado" => null,
                    "referencia" => "",
                    "limite_productos" => $paquete->limite_productos,
                    "limite_anuncios" => $paquete->limite_anuncios,
                    "monto_a_cancelar" => $paquete->costo,
                    "aprobado" => 0,
                    "infocompra" => $paquete->infocompra,
                    "fecha_inicio" => null
                );
                $result = $this->vendedor_model->verificar_disponibilidad($vendedor->id);
                if ($result) {
                    if ($this->config->item('emails_enabled')) {
                        $this->load->library('email');
                        $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                        $this->email->to($usuario->email);
                        $this->email->subject('Informacion para pago del paquete');
                        $data_email = array("paquete" => $data);
                        $this->email->message($this->load->view('home/emails/informacion_de_compra', $data_email, true));
                        $this->email->send();
                    }
                    $this->vendedor_paquete_model->insert($data);
                }
                redirect('usuario/mis-paquetes');
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

    /*
     * 
     */

    public function view_buscador() {
        $this->template->set_title('Mercabarato - Busca y Compara');
        $this->template->add_js('modules/home/vendedores_listado.js');
        //$paises = $this->pais_model->get_all();
        $provincias = $this->provincia_model->get_all_by_pais(70);
        //$provincias = array();
        $poblaciones = array();
        $localizacion = false;

        if ($this->authentication->is_loggedin()) {
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
            $anuncios = $this->anuncio_model->get_anuncios_para_cliente($cliente->id);

            $var = $this->session->userdata('vendedores_ver_localuser');
            if ($var) {
                $localizacion_user = $this->localizacion_model->get_by("usuario_id", $user_id);
                $localizacion = $this->localizacion_model->get_full_localizacion($localizacion_user->id);
                if ($localizacion["pais"] != null) {
                    $provincias = $this->provincia_model->get_all_by_pais($localizacion["pais"]->id);
                    if ($localizacion["provincia"] != null) {
                        $poblaciones = $this->poblacion_model->get_all_by_provincia($localizacion["provincia"]->id);
                    }
                }
            }
        } else {
            $anuncios = $this->anuncio_model->get_ultimos_anuncios();
        }

        if (!$anuncios) {
            $anuncios = array();
        }

        $data = array(
            //"paises" => $paises, 
            "provincias" => $provincias,
            "poblaciones" => $poblaciones,
            "localizacion" => $localizacion,
            "anuncios" => $anuncios);

        $this->template->load_view('home/vendedores/listado', $data);
    }

    /**
     * 
     */
    public function ajax_get_listado_resultados() {
        if ($this->input->is_ajax_request()) {
            //$this->show_profiler();
            $formValues = $this->input->post();

            $params = array();
            if ($formValues !== false) {
                if ($this->input->post('search_query') != "") {
                    $params["nombre"] = $this->input->post('search_query');
                    $params["descripcion"] = $this->input->post('search_query');
                    $params["keyword"] = $this->input->post('search_query');
                }
                if ($this->input->post('pais') != "0") {
                    $params["pais"] = $this->input->post('pais');
                }
                if ($this->input->post('provincia') != "0") {
                    $params["provincia"] = $this->input->post('provincia');
                }
                if ($this->input->post('poblacion') != "0") {
                    $params["poblacion"] = $this->input->post('poblacion');
                }

                $pagina = $this->input->post('pagina');
            } else {
                $pagina = 1;
            }

            if ($this->authentication->is_loggedin()) {
                $user_id = $this->authentication->read('identifier');
                $identidad = $this->usuario_model->get_full_identidad($user_id);
                if ($identidad->es_vendedor()) {
                    $vendedor_id_logged = $identidad->get_vendedor_id();
                } else {
                    $vendedor_id_logged = -1;
                }
                $keywords_cliente = $this->keyword_model->get_keyword($identidad->cliente->keyword);
                if ($keywords_cliente) {
                    $params["keyword"] = $keywords_cliente;
                }
                $params["usuario_id"] = $user_id;
                $logged_in = true;
            } else {
                $logged_in = false;
                $vendedor_id_logged = -1;
            }

            //$limit = $this->config->item("principal_default_per_page");
            $limit = 5;
            $offset = $limit * ($pagina - 1);
            $vendedores_array = $this->vendedor_model->get_site_search($params, $limit, $offset);
            $flt = (float) ($vendedores_array["total"] / $limit);
            $ent = (int) ($vendedores_array["total"] / $limit);
            if ($flt > $ent || $flt < $ent) {
                $paginas = $ent + 1;
            } else {
                $paginas = $ent;
            }

            if ($vendedores_array["total"] == 0) {
                $vendedores_array["vendedores"] = array();
            }

            $search_params = array(
                "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
                "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
                "pagina" => $pagina,
                "total_paginas" => $paginas,
                "por_pagina" => $limit,
                "total" => $vendedores_array["total"],
                "hasta" => ($pagina * $limit < $vendedores_array["total"]) ? $pagina * $limit : $vendedores_array["total"],
                "desde" => (($pagina * $limit) - $limit) + 1);
            $pagination = build_paginacion($search_params);

            $data = array(
                "vendedores" => $vendedores_array["vendedores"],
                "pagination" => $pagination,
                "logged_in" => $logged_in,
                "vendedor_id_logged" => $vendedor_id_logged);

            $this->template->load_view('home/vendedores/tabla_resultados', $data);
        } else {
            redirect('');
        }
    }

    /**
     * 
     * @param type $slug
     */
    public function ver_vendedor($slug) {
        $this->template->set_title('Mercabarato - Busca y Compara');

        $vendedor = $this->vendedor_model->get_vendedor_by_slug($slug);
        if ($vendedor) {
            if ($vendedor->habilitado == 1) {
                $this->template->add_js('modules/home/vendedor.js');
                $localizacion = $this->localizacion_model->get_by("usuario_id", $vendedor->usuario_id);

                if ($localizacion->pais_id != null) {
                    $res = $this->pais_model->get($localizacion->pais_id);
                    $localizacion->pais = $res->nombre;
                }
                if ($localizacion->provincia_id != null) {
                    $res = $this->provincia_model->get($localizacion->provincia_id);
                    $localizacion->provincia = $res->nombre;
                }
                if ($localizacion->poblacion_id != null) {
                    $res = $this->poblacion_model->get($localizacion->poblacion_id);
                    $localizacion->poblacion = $res->nombre;
                }

                $anuncios = $this->anuncio_model->get_anuncios_del_vendedor($vendedor->id, 3);
                $params = array(
                    "vendedor_id" => $vendedor->id,
                    "mostrar_producto" => "1"
                );

                $vendedor_image = false;

                if ($this->authentication->is_loggedin()) {
                    $user_id = $this->authentication->read('identifier');
                    $cliente_vendedor = $this->cliente_model->get($vendedor->cliente_id);
                    $invitacion = $this->invitacion_model->invitacion_existe($user_id, $cliente_vendedor->usuario_id);
                    $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
                    $params["cliente_id"] = $cliente->id;
                    $son_contactos = $this->invitacion_model->son_contactos($user_id, $cliente_vendedor->usuario_id);
                    
                    if($user_id==$cliente_vendedor->usuario_id){
                        $son_contactos=true;
                    }

                    $cliente_datos_contacto = $this->usuario_model->get_full_identidad($user_id);
                } else {
                    $invitacion = true;
                    $son_contactos = false;
                }

                $productos = $this->producto_model->get_site_search($params, 4, 0, "p.fecha_insertado", "DESC");
                if ($productos["total"] > 0) {
                    $prods = $productos["productos"];
                } else {
                    $prods = false;
                }

                $paquete_curso = $this->vendedor_model->get_paquete_en_curso($vendedor->id);
                $infocompras = false;
                if ($paquete_curso) {
                    if ($paquete_curso->infocompra == "1") {
                        $infocompras = true;
                    }
                }

                $data = array(
                    "vendedor" => $vendedor,
                    "vendedor_image" => $vendedor_image,
                    "localizacion" => $localizacion,
                    "invitacion" => $invitacion,
                    "anuncios" => $anuncios,
                    "productos" => $prods,
                    "son_contactos" => $son_contactos,
                    "infocompras" => $infocompras
                );

                if ($infocompras) {
                    $formulario_data = array();
                    if ($this->authentication->is_loggedin()) {
                        $formulario_data["datos_contacto"] = $cliente_datos_contacto;
                    }

                    $ya_envie = $this->session->userdata('infocompras_enviado_vendedor_id');

                    $this->session->unset_userdata('infocompras_vendedor_id');

                    if ($ya_envie == $vendedor->id) {
                        $formularios = '<div>';
                        $formularios.='<div class="alert alert-warning">';
                        $formularios.='<p> Ya le has enviado a este vendedor una solicitud de seguro en esta sesion. </p>';
                        $formularios.= '</div>';
                        $formularios.= '</div>';
                    } else {
                        $this->session->set_userdata(array('infocompras_vendedor_id' => $vendedor->id));
                        $this->template->add_js('modules/home/seguros_vendedor.js');
                        $formularios = $this->load->view('home/seguro/formulario_vendedores', $formulario_data, true);
                    }

                    $data["formularios"] = $formularios;
                    $this->template->load_view('home/vendedores/ficha', $data);
                } else {
                    $this->template->load_view('home/vendedores/ficha', $data);
                }
            } else {
                show_404();
            }
        } else {
            show_404();
        }
    }

    /**
     * 
     */
    public function upload_image() {
        $this->load->config('upload', TRUE);
        $this->load->library('UploadHandler', $this->config->item('vendedor', 'upload'));
    }

    /**
     *  usuario / perfil
     */
    public function view_datos_vendedor() {
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

            $puntos_venta = $this->punto_venta_model->get_many_by("vendedor_id", $vendedor->id);

            $keywords = $this->categoria_model->get_keywords_from_categorias();

            $keywords_cliente = $this->keyword_model->get_keyword($vendedor->keyword);
            if ($keywords_cliente) {
                $mis_intereses = explode(";", $keywords_cliente);
            } else {
                $mis_intereses = array();
            }

            $localizacion = $this->localizacion_model->get_by("usuario_id", $cliente->usuario_id);
            $provincias = $this->provincia_model->get_all_by_pais(70);
            $poblaciones = array();
            $provincia_id = 0;
            $poblacion_id = 0;

            if ($localizacion) {
                if ($localizacion->provincia_id != null) {
                    $provincia_id = $localizacion->provincia_id;
                    $poblaciones = $this->poblacion_model->get_all_by_provincia($provincia_id);
                }
                if ($localizacion->poblacion_id != null) {
                    $poblacion_id = $localizacion->poblacion_id;
                }
            }

            $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);
            $this->template->add_js('modules/home/perfil.js');
            $this->template->load_view('home/vendedor/datos_vendedor', array(
                "usuario" => $usuario,
                "cliente" => $cliente,
                "vendedor" => $vendedor,
                "html_options" => $html_options,
                "keywords" => $keywords,
                "mis_intereses" => $mis_intereses,
                "puntos_venta" => $puntos_venta,
                "provincias" => $provincias,
                "poblaciones" => $poblaciones,
                "provincia_id" => $provincia_id,
                "poblacion_id" => $poblacion_id)
            );
        } else {
            redirect('');
        }
    }

    public function modificar_datos() {
        $formValues = $this->input->post();
        $config = array(
            'table' => 'vendedor',
            'id' => 'id',
            'field' => 'unique_slug',
            'title' => 'nombre',
            'replacement' => 'dash' // Either dash or underscore
        );
        $this->load->library('slug', $config);
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


                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);

                if ($this->input->post('file_name') !== "") {
                    $filename = $this->input->post('file_name');
                    $this->vendedor_model->cleanup_image($vendedor->id);
                } else {
                    $filename = null;
                }

                if ($keywords_text != null) {
                    $keyword_id = $this->keyword_model->insert(array("keywords" => $keywords_text));
                } else {
                    $keyword_id = null;
                }

                $data_vendedor = array(
                    "nombre" => ($this->input->post('nombre_empresa') != '') ? $this->input->post('nombre_empresa') : null,
                    "descripcion" => ($this->input->post('descripcion') != '') ? $this->input->post('descripcion') : null,
                    "sitio_web" => ($this->input->post('sitio_web') != '') ? $this->input->post('sitio_web') : null,
                    "actividad" => ($this->input->post('actividad') != '') ? $this->input->post('actividad') : null,
                    "nif_cif" => ($this->input->post('nif_cif') != '') ? $this->input->post('nif_cif') : null,
                    "direccion" => ($this->input->post('direccion') != '') ? $this->input->post('direccion') : null,
                    "telefono_fijo" => ($this->input->post('telefono_fijo') != '') ? $this->input->post('telefono_fijo') : null,
                    "telefono_movil" => ($this->input->post('telefono_movil') != '') ? $this->input->post('telefono_movil') : null,
                    "filename" => $filename,
                    "keyword" => $keyword_id
                );

                $data_puntos_venta = array();
                if ($this->input->post('nombre_punto_venta_1') != "") {
                    $data_puntos_venta[] = array(
                        "id" => $this->input->post('id_punto_venta_1'),
                        "nombre" => $this->input->post('nombre_punto_venta_1'),
                        "direccion" => $this->input->post("direccion_punto_venta_1")
                    );
                } elseif ($this->input->post('id_punto_venta_1') != "") {
                    $pt = $this->punto_venta_model->get($this->input->post('id_punto_venta_1'));
                    if ($pt) {
                        if ($pt->vendedor_id == $vendedor->id) {
                            $this->punto_venta_model->delete($this->input->post('id_punto_venta_1'));
                        }
                    }
                }
                if ($this->input->post('nombre_punto_venta_2') != "") {
                    $data_puntos_venta[] = array(
                        "id" => $this->input->post('id_punto_venta_2'),
                        "nombre" => $this->input->post('nombre_punto_venta_2'),
                        "direccion" => $this->input->post("direccion_punto_venta_2")
                    );
                } elseif ($this->input->post('id_punto_venta_2') != "") {
                    $pt = $this->punto_venta_model->get($this->input->post('id_punto_venta_2'));
                    if ($pt) {
                        if ($pt->vendedor_id == $vendedor->id) {
                            $this->punto_venta_model->delete($this->input->post('id_punto_venta_2'));
                        }
                    }
                }

                if ($this->input->post('nombre_punto_venta_3') != "") {
                    $data_puntos_venta[] = array(
                        "id" => $this->input->post('id_punto_venta_3'),
                        "nombre" => $this->input->post('nombre_punto_venta_3'),
                        "direccion" => $this->input->post("direccion_punto_venta_3")
                    );
                } elseif ($this->input->post('id_punto_venta_3') != "") {
                    $pt = $this->punto_venta_model->get($this->input->post('id_punto_venta_3'));
                    if ($pt) {
                        if ($pt->vendedor_id == $vendedor->id) {
                            $this->punto_venta_model->delete($this->input->post('id_punto_venta_3'));
                        }
                    }
                }

                if ($data_puntos_venta) {
                    foreach ($data_puntos_venta as $punto) {
                        if ($punto["id"] != "") {
                            $id = $punto["id"];
                            unset($punto["id"]);
                            $this->punto_venta_model->update($id, array(
                                "vendedor_id" => $vendedor->id,
                                "nombre" => $punto["nombre"],
                                "direccion" => $punto["direccion"]
                            ));
                        } else {
                            $this->punto_venta_model->insert(array(
                                "vendedor_id" => $vendedor->id,
                                "nombre" => $punto["nombre"],
                                "direccion" => $punto["direccion"]
                            ));
                        }
                    }
                }

                if ($this->input->post("provincia") != "") {
                    $this->localizacion_model->update_by(array("usuario_id" => $user_id), array("provincia_id" => $this->input->post("provincia")));
                }
                if ($this->input->post("poblacion") != "") {
                    $this->localizacion_model->update_by(array("usuario_id" => $user_id), array("poblacion_id" => $this->input->post("poblacion")));
                }


                //$usuario = $this->usuario_model->get($user_id);
                //$data_vendedor["unique_slug"] = $this->slug->create_uri($usuario->nickname);
                $this->vendedor_model->update($vendedor->id, $data_vendedor);

                $this->session->set_flashdata('success', 'Tus datos han sido modificados con exito.');
            }
            redirect('usuario/perfil');
        } else {
            redirect('usuario/perfil');
        }
    }

    public function renovar_paquetes() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            if ($this->cliente_model->es_vendedor($cliente->id)) {
                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);
                $paquetes = $this->paquete_model->get_paquetes();

                $paquete_en_curso = $this->vendedor_model->get_paquete_en_curso($vendedor->id);
                $date = strtotime(date("Y-m-d"));
                $date = strtotime("+5 day", $date);
                $date5 = date('Y-m-d', $date);

                if ($paquete_en_curso) {
                    if ($paquete_en_curso->fecha_terminar <= $date5) {
                        $renovar = true;
                    } else {
                        $renovar = false;
                    }
                } else {
                    $renovar = false;
                }

                $paquete_pendiente = $this->vendedor_model->get_paquete_pendiente($vendedor->id);
                $paquete_renovacion = $this->vendedor_model->get_paquete_renovacion($vendedor->id);
                if ($paquete_pendiente || $paquete_renovacion) {
                    $renovar = false;
                }

                if ($renovar) {
                    $cliente_es_vendedor = $this->cliente_model->es_vendedor($cliente->id);
                    $html_options = $this->load->view('home/partials/panel_opciones', array("es_vendedor" => $cliente_es_vendedor), true);

                    $data = array(
                        "html_options" => $html_options,
                        "cliente" => $cliente,
                        "paquetes" => $paquetes,
                    );
                    $this->template->add_js('modules/home/perfil.js');
                    $this->template->load_view('home/vendedor/renovar_paquete', $data);
                } else {
                    redirect('usuario/perfil');
                }
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

    public function submit_renovar_paquetes($paquete_id) {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Busca y Compara');

            if ($this->paquete_model->validar_paquete($paquete_id)) {
                $user_id = $this->authentication->read('identifier');
                $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
                $vendedor = $this->vendedor_model->get_by("cliente_id", $cliente->id);
                $usuario = $this->usuario_model->get($cliente->usuario_id);
                $paquete = $this->paquete_model->get($paquete_id);

                $paquete_en_curso = $this->vendedor_model->get_paquete_en_curso($vendedor->id);

                if ($paquete_en_curso) {
                    $date = strtotime($paquete_en_curso->fecha_terminar);
                    $date = strtotime("+1 day", $date);
                    $date1 = date('Y-m-d', $date);

                    $data = array(
                        "vendedor_id" => $vendedor->id,
                        "nombre_paquete" => $paquete->nombre,
                        "duracion_paquete" => $paquete->duracion,
                        "fecha_comprado" => date('Y-m-d'),
                        "fecha_terminar" => null,
                        "fecha_aprobado" => null,
                        "referencia" => "",
                        "limite_productos" => $paquete->limite_productos,
                        "limite_anuncios" => $paquete->limite_anuncios,
                        "monto_a_cancelar" => $paquete->costo,
                        "aprobado" => 0,
                        "infocompra" => $paquete->infocompra,
                        "fecha_inicio" => $date1
                    );
                    $result = $this->vendedor_model->verificar_disponibilidad_renovacion($vendedor->id);
                    if ($result) {
                        if ($this->config->item('emails_enabled')) {
                            $this->load->library('email');
                            $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                            $this->email->to($usuario->email);
                            $this->email->subject('Informacion para pago del paquete');
                            $data_email = array("paquete" => $data);
                            $this->email->message($this->load->view('home/emails/informacion_de_compra', $data_email, true));
                            $this->email->send();
                        }
                        $this->vendedor_paquete_model->insert($data);
                    }
                }
                redirect('usuario/mis-paquetes');
            } else {
                redirect('usuario/perfil');
            }
        } else {
            redirect('');
        }
    }

    public function ver_productos($slug, $param1=false , $param2=false ,$param3 = false) {
        $vendedor = $this->vendedor_model->get_vendedor_by_slug($slug);
        if ($vendedor) {
            if ($vendedor->habilitado == 1) {
                $anuncios = $this->anuncio_model->get_anuncios_del_vendedor($vendedor->id, 3);
                $data = array(
                    "vendedor" => $vendedor,
                    "anuncios" => $anuncios,
                    "grupo_txt" => $param1,
                    "familia_txt" => $param2,
                    "subfamilia_txt" => $param3,
                );
                $this->template->add_js('modules/home/vendedores_ver_productos.js');
                $this->template->load_view('home/vendedores/ver_productos', $data);
            } else {
                redirect('404');
            }
        } else {
            redirect('404');
        }
    }

    public function ver_productos_listado() {
        if ($this->input->is_ajax_request()) {
            $this->ajax_header();
            //$this->show_profiler();
            $formValues = $this->input->post();
            $params = array();
            if ($formValues !== false) {
                $params["vendedor_id"] = $this->input->post('vendedor_id');
                $params["habilitado"] = "1";
                $params["mostrar_producto"] = "1";
                
                if($this->input->post('grupo_txt')!=""){
                    $params["order_by_grupo_txt"] = $this->input->post('grupo_txt');
                    $params["grupo_txt"] = $this->input->post('grupo_txt');
                }
                
                if($this->input->post('familia_txt')!=""){
                    $params["order_by_familia_txt"] = $this->input->post('familia_txt');
                    $params["familia_txt"] = $this->input->post('familia_txt');
                }
                
                if($this->input->post('subfamilia_txt')!=""){
                    $params["order_by_subfamilia_txt"] = $this->input->post('subfamilia_txt');
                    $params["subfamilia_txt"] = $this->input->post('subfamilia_txt');
                }
                
                $pagina = $this->input->post('pagina');

                $limit = $this->config->item("principal_default_per_page");
                $offset = $limit * ($pagina - 1);
                $productos = $this->producto_model->get_site_search($params, $limit, $offset, "relevance", "DESC");
                $flt = (float) ($productos["total"] / $limit);
                $ent = (int) ($productos["total"] / $limit);
                if ($flt > $ent || $flt < $ent) {
                    $paginas = $ent + 1;
                } else {
                    $paginas = $ent;
                }

                if ($productos["total"] == 0) {
                    $productos["productos"] = array();
                }

                $search_params = array(
                    "anterior" => (($pagina - 1) < 1) ? -1 : ($pagina - 1),
                    "siguiente" => (($pagina + 1) > $paginas) ? -1 : ($pagina + 1),
                    "pagina" => $pagina,
                    "total_paginas" => $paginas,
                    "por_pagina" => $limit,
                    "total" => $productos["total"],
                    "hasta" => ($pagina * $limit < $productos["total"]) ? $pagina * $limit : $productos["total"],
                    "desde" => (($pagina * $limit) - $limit) + 1);

                $pagination = build_paginacion($search_params);
                $data = array(
                    "productos" => $productos["productos"],
                    "pagination" => $pagination);


                $this->template->load_view('home/producto/tabla_resultados_principal', $data);
            }
        } else {
            redirect('');
        }
    }

}
