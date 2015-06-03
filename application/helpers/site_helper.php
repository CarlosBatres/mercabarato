<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function vendedor_actividad_dropdown($pos = null) {
    $data = array(        
        'No Especificada' => 'No Especificada',
        'Actividad Temporal' => 'Actividad Temporal',        
        'Actividad Temporal Dos' => 'Actividad Temporal Dos',        
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