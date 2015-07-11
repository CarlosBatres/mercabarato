<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Seguro extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function view_seguros() {
        if ($this->authentication->is_loggedin()) {
            $this->template->set_title('Mercabarato - Anuncios y subastas');
            $user_id = $this->authentication->read('identifier');
            $cliente = $this->cliente_model->get_by("usuario_id", $user_id);

            $this->template->add_js('modules/home/seguros.js');
            $data = array();
            $this->template->load_view('home/seguro/formulario', $data);
        } else {
            $this->template->set_title('Mercabarato - Anuncios y subastas');

            $this->template->add_js('modules/home/seguros.js');
            $data = array();
            $this->template->load_view('home/seguro/formulario', $data);
        }
    }

    public function registrar_seguro() {
        $formValues = $this->input->post();

        if ($formValues !== false) {
            // datos contacto
            $nombres = ($this->input->post('nombres') != '') ? $this->input->post('nombres') : null;
            $apellidos = ($this->input->post('apellidos') != '') ? $this->input->post('apellidos') : null;
            $telefono_contacto = ($this->input->post('telefono_contacto') != '') ? $this->input->post('telefono_contacto') : null;
            $email = ($this->input->post('email') != '') ? $this->input->post('email') : null;
            $observaciones = ($this->input->post('observaciones') != '') ? $this->input->post('observaciones') : null;
            
            //hogar
            $edificio_apartamento = ($this->input->post('edificio_apartamento') != '') ? $this->input->post('edificio_apartamento') : null;
            $edificio_vivienda=($this->input->post('edificio_vivienda') != '') ? $this->input->post('edificio_vivienda') : null;
            $metros_construidos=($this->input->post('metros_construidos') != '') ? $this->input->post('metros_construidos') : null;
            $numero_habitantes=($this->input->post('numero_habitantes') != '') ? $this->input->post('numero_habitantes') : null;
            $uso=($this->input->post('uso') != '') ? $this->input->post('uso') : null;
            $regimen_vivienda=($this->input->post('regimen_vivienda') != '') ? $this->input->post('regimen_vivienda') : null;
            $numero_banos=($this->input->post('numero_banos') != '') ? $this->input->post('numero_banos') : null;
            $construccion_estandar=($this->input->post('construccion_estandar') != '') ? $this->input->post('construccion_estandar') : null;
            $calidad_construccion=($this->input->post('calidad_construccion') != '') ? $this->input->post('calidad_construccion') : null;
            $año_construccion=($this->input->post('year_construccion') != '') ? $this->input->post('year_construccion') : null;
            $año_ultima_reforma=($this->input->post('year_ultima_reforma') != '') ? $this->input->post('year_ultima_reforma') : null;
            
            $sistema_seguridad=($this->input->post('sistema_seguridad') != '') ? $this->input->post('sistema_seguridad') : null;
            $rejas_ventana=  ($this->input->post('rejas_ventana') != '') ? $this->input->post('rejas_ventana') : null;
            $puerta_acorazada=($this->input->post('puerta_acorazada') != '') ? $this->input->post('puerta_acorazada') : null;
            $prestamo_hipotecario=($this->input->post('prestamo_hipotecario') != '') ? $this->input->post('prestamo_hipotecario') : null;
            
            $contiene=($this->input->post('contiene') != '') ? $this->input->post('contiene') : null;
            $contenido_mobiliario=($this->input->post('contenido_mobiliario') != '') ? $this->input->post('contenido_mobiliario') : null;
            $joyas=($this->input->post('joyas') != '') ? $this->input->post('joyas') : null;
            $valor_especial=($this->input->post('valor_especial') != '') ? $this->input->post('valor_especial') : null;
            $daños_esteticos=($this->input->post('danos_esteticos') != '') ? $this->input->post('danos_esteticos') : null;
            $responsibilidad_civil=($this->input->post('responsibilidad_civil') != '') ? $this->input->post('responsibilidad_civil') : null;
            
            
            // RIESGO
            $nif_nie=($this->input->post('nif_nie') != '') ? $this->input->post('nif_nie') : null;
            $sexo=($this->input->post('sexo') != '') ? $this->input->post('sexo') : null;
            $fecha_nacimiento=($this->input->post('fecha_nacimiento') != '') ? $this->input->post('fecha_nacimiento') : null;
            $profesion=($this->input->post('profesion') != '') ? $this->input->post('profesion') : null;
            
            // SALUD
            
            $provincia_grupo_familiar=($this->input->post('provincia_grupo_familiar') != '') ? $this->input->post('provincia_grupo_familiar') : null;
            $numero_personas=($this->input->post('numero_personas') != '') ? $this->input->post('numero_personas') : null;
            $nombres_titular=($this->input->post('nombres_titular') != '') ? $this->input->post('nombres_titular') : null;
            $apellidos_titular=($this->input->post('apellidos_titular') != '') ? $this->input->post('apellidos_titular') : null;
            $fecha_nacimiento=($this->input->post('fecha_nacimiento') != '') ? $this->input->post('fecha_nacimiento') : null;
            $sexo=($this->input->post('sexo') != '') ? $this->input->post('sexo') : null;
            $trabajo_remunerado=($this->input->post('trabajo_remunerado') != '') ? $this->input->post('trabajo_remunerado') : null;
            $modalidad_contratacion=($this->input->post('modalidad_contratacion') != '') ? $this->input->post('modalidad_contratacion') : null;
            
            // VEHICULO
            $tipo_vehiculo=($this->input->post('tipo_vehiculo') != '') ? $this->input->post('tipo_vehiculo') : null;
            $marca=($this->input->post('marca') != '') ? $this->input->post('marca') : null;
            $modelo=($this->input->post('modelo') != '') ? $this->input->post('modelo') : null;
            $vehiculo_combustible=($this->input->post('vehiculo_combustible') != '') ? $this->input->post('vehiculo_combustible') : null;
            $vehiculo_nro_puertas=($this->input->post('vehiculo_nro_puertas') != '') ? $this->input->post('vehiculo_nro_puertas') : null;
            $fecha_matriculacion=($this->input->post('fecha_matriculacion') != '') ? $this->input->post('fecha_matriculacion') : null;
            $matricula=($this->input->post('matricula') != '') ? $this->input->post('matricula') : null;
            $fecha_nacimiento=($this->input->post('fecha_nacimiento') != '') ? $this->input->post('fecha_nacimiento') : null;
            $sexo=($this->input->post('sexo') != '') ? $this->input->post('sexo') : null;
            $estado_civil=($this->input->post('estado_civil') != '') ? $this->input->post('estado_civil') : null;
            $tipo_documento=($this->input->post('tipo_documento') != '') ? $this->input->post('tipo_documento') : null;
            $numero_documento=($this->input->post('numero_documento') != '') ? $this->input->post('numero_documento') : null;
            $fecha_permiso=($this->input->post('fecha_permiso') != '') ? $this->input->post('fecha_permiso') : null;
            $conductor_clase=($this->input->post('conductor_clase') != '') ? $this->input->post('conductor_clase') : null;
            $codigo_postal=($this->input->post('codigo_postal') != '') ? $this->input->post('codigo_postal') : null;
            $provicia=($this->input->post('provicia') != '') ? $this->input->post('provicia') : null;
            
            //OTROS
            $otros=($this->input->post('otros') != '') ? $this->input->post('otros') : null;                                    
            
            $tipo=($this->input->post('tipo') != '') ? $this->input->post('tipo') : null;    
            
            
            
        }
    }

}
