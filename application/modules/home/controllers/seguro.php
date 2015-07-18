<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Seguro extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     */
    public function view_seguros() {
        $this->session->unset_userdata('seguros_tipo');
        $this->session->unset_userdata('seguros_datos_contacto');
        $this->session->unset_userdata('seguros_informacion');
        $this->session->unset_userdata('seguros_ignore_list');

        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->usuario_model->get_full_identidad($user_id);

            $this->template->add_js('modules/home/seguros.js');
            $data = array("datos_contacto" => $cliente);
            $this->template->load_view('home/seguro/formulario', $data);
        } else {
            $this->template->set_title('Mercabarato - Anuncios y subastas');

            $this->template->add_js('modules/home/seguros.js');
            $data = array();
            $this->template->load_view('home/seguro/formulario', $data);
        }
    }

    /**
     * 
     */
    public function registrar_seguro() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $tipo = ($this->input->post('tipo') != '') ? $this->input->post('tipo') : null;

            $datos_contacto = array(
                "nombres" => ($this->input->post('nombres') != '') ? $this->input->post('nombres') : null,
                "apellidos" => ($this->input->post('apellidos') != '') ? $this->input->post('apellidos') : null,
                "telefono_contacto" => ($this->input->post('telefono_contacto') != '') ? $this->input->post('telefono_contacto') : null,
                "email" => ($this->input->post('email') != '') ? $this->input->post('email') : null,
                "observaciones" => ($this->input->post('observaciones') != '') ? $this->input->post('observaciones') : null
            );

            $datos_hogar = array(
                "edificio_apartamento" => ($this->input->post('edificio_apartamento') != '') ? $this->input->post('edificio_apartamento') : null,
                "edificio_vivienda" => ($this->input->post('edificio_vivienda') != '') ? $this->input->post('edificio_vivienda') : null,
                "metros_construidos" => ($this->input->post('metros_construidos') != '') ? $this->input->post('metros_construidos') : null,
                "numero_habitantes" => ($this->input->post('numero_habitantes') != '') ? $this->input->post('numero_habitantes') : null,
                "uso" => ($this->input->post('uso') != '') ? $this->input->post('uso') : null,
                "regimen_vivienda" => ($this->input->post('regimen_vivienda') != '') ? $this->input->post('regimen_vivienda') : null,
                "numero_banos" => ($this->input->post('numero_banos') != '') ? $this->input->post('numero_banos') : null,
                "construccion_estandar" => ($this->input->post('construccion_estandar') != '') ? $this->input->post('construccion_estandar') : null,
                "calidad_construccion" => ($this->input->post('calidad_construccion') != '') ? $this->input->post('calidad_construccion') : null,
                "año_construccion" => ($this->input->post('year_construccion') != '') ? $this->input->post('year_construccion') : null,
                "año_ultima_reforma" => ($this->input->post('year_ultima_reforma') != '') ? $this->input->post('year_ultima_reforma') : null,
                "sistema_seguridad" => ($this->input->post('sistema_seguridad') != '') ? $this->input->post('sistema_seguridad') : null,
                "rejas_ventana" => ($this->input->post('rejas_ventana') != '') ? $this->input->post('rejas_ventana') : null,
                "puerta_acorazada" => ($this->input->post('puerta_acorazada') != '') ? $this->input->post('puerta_acorazada') : null,
                "prestamo_hipotecario" => ($this->input->post('prestamo_hipotecario') != '') ? $this->input->post('prestamo_hipotecario') : null,
                "contiene" => ($this->input->post('contiene') != '') ? $this->input->post('contiene') : null,
                "contenido_mobiliario" => ($this->input->post('contenido_mobiliario') != '') ? $this->input->post('contenido_mobiliario') : null,
                "joyas" => ($this->input->post('joyas') != '') ? $this->input->post('joyas') : null,
                "valor_especial" => ($this->input->post('valor_especial') != '') ? $this->input->post('valor_especial') : null,
                "daños_esteticos" => ($this->input->post('danos_esteticos') != '') ? $this->input->post('danos_esteticos') : null,
                "responsibilidad_civil" => ($this->input->post('responsibilidad_civil') != '') ? $this->input->post('responsibilidad_civil') : null
            );

            $datos_riesgo = array(
                "nif_nie" => ($this->input->post('nif_nie') != '') ? $this->input->post('nif_nie') : null,
                "sexo" => ($this->input->post('sexo') != '') ? $this->input->post('sexo') : null,
                "fecha_nacimiento" => ($this->input->post('fecha_nacimiento') != '') ? $this->input->post('fecha_nacimiento') : null,
                "profesion" => ($this->input->post('profesion') != '') ? $this->input->post('profesion') : null
            );

            $datos_salud = array(
                "provincia_grupo_familiar" => ($this->input->post('provincia_grupo_familiar') != '') ? $this->input->post('provincia_grupo_familiar') : null,
                "numero_personas" => ($this->input->post('numero_personas') != '') ? $this->input->post('numero_personas') : null,
                "nombres_titular" => ($this->input->post('nombres_titular') != '') ? $this->input->post('nombres_titular') : null,
                "apellidos_titular" => ($this->input->post('apellidos_titular') != '') ? $this->input->post('apellidos_titular') : null,
                "fecha_nacimiento" => ($this->input->post('fecha_nacimiento') != '') ? $this->input->post('fecha_nacimiento') : null,
                "sexo" => ($this->input->post('sexo') != '') ? $this->input->post('sexo') : null,
                "trabajo_remunerado" => ($this->input->post('trabajo_remunerado') != '') ? $this->input->post('trabajo_remunerado') : null,
                "modalidad_contratacion" => ($this->input->post('modalidad_contratacion') != '') ? $this->input->post('modalidad_contratacion') : null
            );

            $datos_vehiculo = array(
                "tipo_vehiculo" => ($this->input->post('tipo_vehiculo') != '') ? $this->input->post('tipo_vehiculo') : null,
                "marca" => ($this->input->post('marca') != '') ? $this->input->post('marca') : null,
                "modelo" => ($this->input->post('modelo') != '') ? $this->input->post('modelo') : null,
                "vehiculo_combustible" => ($this->input->post('vehiculo_combustible') != '') ? $this->input->post('vehiculo_combustible') : null,
                "vehiculo_nro_puertas" => ($this->input->post('vehiculo_nro_puertas') != '') ? $this->input->post('vehiculo_nro_puertas') : null,
                "fecha_matriculacion" => ($this->input->post('fecha_matriculacion') != '') ? $this->input->post('fecha_matriculacion') : null,
                "matricula" => ($this->input->post('matricula') != '') ? $this->input->post('matricula') : null,
                "fecha_nacimiento" => ($this->input->post('fecha_nacimiento') != '') ? $this->input->post('fecha_nacimiento') : null,
                "sexo" => ($this->input->post('sexo') != '') ? $this->input->post('sexo') : null,
                "estado_civil" => ($this->input->post('estado_civil') != '') ? $this->input->post('estado_civil') : null,
                "tipo_documento" => ($this->input->post('tipo_documento') != '') ? $this->input->post('tipo_documento') : null,
                "numero_documento" => ($this->input->post('numero_documento') != '') ? $this->input->post('numero_documento') : null,
                "fecha_permiso" => ($this->input->post('fecha_permiso') != '') ? $this->input->post('fecha_permiso') : null,
                "conductor_clase" => ($this->input->post('conductor_clase') != '') ? $this->input->post('conductor_clase') : null,
                "codigo_postal" => ($this->input->post('codigo_postal') != '') ? $this->input->post('codigo_postal') : null,
                "provicia" => ($this->input->post('provicia') != '') ? $this->input->post('provicia') : null
            );

            $datos_otros = array(
                "otros" => ($this->input->post('otros') != '') ? $this->input->post('otros') : null
            );


            $this->session->set_userdata(array(
                'seguros_tipo' => $tipo,
                'seguros_datos_contacto' => $datos_contacto,
            ));

            if ($tipo == "seguro_otros") {
                $this->session->set_userdata(array(
                    'seguros_informacion' => $datos_otros,
                ));
            } elseif ($tipo == "seguro_hogar") {
                $this->session->set_userdata(array(
                    'seguros_informacion' => $datos_hogar,
                ));
            } elseif ($tipo == "seguro_riesgo") {
                $this->session->set_userdata(array(
                    'seguros_informacion' => $datos_riesgo,
                ));
            } elseif ($tipo == "seguro_salud") {
                $this->session->set_userdata(array(
                    'seguros_informacion' => $datos_salud,
                ));
            } elseif ($tipo == "seguro_vehiculo") {
                $this->session->set_userdata(array(
                    'seguros_informacion' => $datos_vehiculo,
                ));
            }

            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $this->template->add_js('modules/home/seguros.js');

            $paises = $this->pais_model->get_all();
            $data = array("paises" => $paises);
            $this->template->load_view('home/seguro/seleccionar_prestador', $data);
        } else {
            redirect('seguros');
        }
    }

    /**
     * 
     */
    public function ajax_get_listado_resultados_prestadores() {
        //$this->show_profiler();
        $formValues = $this->input->post();

        $params = array();
        if ($formValues !== false) {
            if ($this->input->post('pais') != "0") {
                $params["pais"] = $this->input->post('pais');
            }
            if ($this->input->post('provincia') != "0") {
                $params["provincia"] = $this->input->post('provincia');
            }
            if ($this->input->post('poblacion') != "0") {
                $params["poblacion"] = $this->input->post('poblacion');
            }
            $params["infocompra"] = 1;
            $params["paquete_vigente"] = true;

            $ignore_list = $this->session->userdata('seguros_ignore_list');
            if ($ignore_list) {
                $params["not_vendedor"] = $ignore_list;
            }

            $pagina = $this->input->post('pagina');
        } else {
            $pagina = 1;
        }

        //$limit = $this->config->item("principal_default_per_page");
        $limit = 5;
        $offset = $limit * ($pagina - 1);
        $vendedores_array = $this->vendedor_paquete_model->buscar_vendedores($params, $limit, $offset);
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
            "pagination" => $pagination);

        $this->template->load_view('home/seguro/tabla_resultados', $data);
    }

    /**
     * 
     */
    public function crear_solicitud_seguro() {
        $formValues = $this->input->post();
        if ($formValues !== false) {
            $vendedor_id = $this->input->post('id');

            $tipo = $this->session->userdata('seguros_tipo');
            $datos_contacto = $this->session->userdata('seguros_datos_contacto');

            if ($this->authentication->is_loggedin()) {
                /**
                 * Si existe el cliente
                 */
                $user_id = $this->authentication->read('identifier');
                $cliente = $this->cliente_model->get_by("usuario_id", $user_id);
                $cliente_id = $cliente->id;
            } else {
                /**
                 * Si no existe el cliente lo creo temporal para que se pueda registrar despues
                 */
                $user_id = $this->authentication->create_user($datos_contacto["email"], "passwordtemporal");
                if ($user_id !== FALSE) {
                    $secret_key = substr(md5(uniqid(mt_rand(), true)), 0, 30);
                    $ip_address = $this->session->userdata('ip_address');
                    $usuario = $this->usuario_model->get($user_id);
                    $usuario->ip_address = $ip_address;
                    $usuario->fecha_creado = date("Y-m-d H:i:s");
                    $usuario->ultimo_acceso = date("Y-m-d H:i:s");
                    $usuario->activo = 0;
                    //$usuario->is_admin = 0;
                    $usuario->temporal = 1;
                    $usuario->secret_key = $secret_key;
                    $this->usuario_model->update($user_id, $usuario);
                }

                $data = array(
                    "usuario_id" => $user_id,
                    "nombres" => $datos_contacto["nombres"],
                    "apellidos" => $datos_contacto["apellidos"],
                    "sexo" => null,
                    "fecha_nacimiento" => null,
                    "codigo_postal" => null,
                    "direccion" => null,
                    "telefono_fijo" => null,
                    "telefono_movil" => null,
                    "keyword" => null
                );

                $cliente_id = $this->cliente_model->insert($data);
            }


            $informacion = $this->session->userdata('seguros_informacion');
            $data = array(
                'tipo' => $tipo,
                'datos_contacto' => $datos_contacto,
                'informacion' => $informacion
            );

            $solicitud_seguro = array(
                "vendedor_id" => $vendedor_id,
                "cliente_id" => $cliente_id,
                "datos" => serialize($data),
                "fecha_solicitud" => date("Y-m-d"),
                "estado" => 0,
            );

            $ignore_list = $this->session->userdata('seguros_ignore_list');
            if (!$ignore_list) {
                $ignore_list = array();
            }
            $ignore_list[] = $vendedor_id;
            $this->session->set_userdata(array(
                'seguros_ignore_list' => $ignore_list,
            ));

            $this->solicitud_seguro_model->insert($solicitud_seguro);
            
            if ($this->config->item('emails_enabled')) {
                $vendedor=$this->vendedor_model->get($vendedor_id);
                $cliente=$this->cliente_model->get($vendedor->cliente_id);
                $usuario=$this->usuario_model->get($cliente->usuario_id);
                
                $this->load->library('email');
                $this->email->from($this->config->item('site_info_email'), 'Mercabarato.com');
                $this->email->to($usuario->email);
                $this->email->subject('Nueva solicitud de presupuesto');
                $data_email = array("data" => $data);
                $this->email->message($this->load->view('home/emails/solicitud_presupuesto', $data_email, true));
                $this->email->send();
            }
        }
    }

    public function finalizar() {
        $this->session->unset_userdata('seguros_tipo');
        $this->session->unset_userdata('seguros_datos_contacto');
        $this->session->unset_userdata('seguros_informacion');
        $this->session->unset_userdata('seguros_ignore_list');
        redirect('');
    }

}
