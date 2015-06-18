<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function vendedor_actividad_dropdown($pos = null) {
    $data = array(        
        'No Especificada' => 'Actividad',
        'Informatica' => 'Informatica',        
        'Seguros' => 'Seguros',        
    );
    $result = null;

    if ($pos === null) {
        $result = $data;
    } else {
        if ($pos !== '' && isset($data[$pos])) {
            $result = $data[$pos];
        }
    }
    return $result;
}

function precios_options($selected = null) {
    //$m=$this->config['money_sign'];
    $m='€';
    $data = array(
        array('value' => '0;;15', 'text' => 'Hasta 15'.$m, 'checked' => false),
        array('value' => '16;;50', 'text' => '16'.$m.' a 50'.$m, 'checked' => false),
        array('value' => '51;;100', 'text' => '51'.$m.' a 100'.$m, 'checked' => false),
        array('value' => '101;;500', 'text' => '101'.$m.' a 500'.$m, 'checked' => false),
        array('value' => '501;;10000', 'text' => 'Mas de 500'.$m, 'checked' => false)
    );

    if ($selected !== null) {
        foreach ($selected as $sel) {
            foreach ($data as $key => $value) {
                if ($value['value'] == $sel) {
                    $data[$key]['checked'] = true;
                }
            }
        }
    }
    return $data;
}