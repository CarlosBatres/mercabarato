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
    $m = '€';
    $data = array(
        array('value' => '0;;15', 'text' => 'Hasta 15' . $m, 'checked' => false),
        array('value' => '16;;50', 'text' => '16' . $m . ' a 50' . $m, 'checked' => false),
        array('value' => '51;;100', 'text' => '51' . $m . ' a 100' . $m, 'checked' => false),
        array('value' => '101;;500', 'text' => '101' . $m . ' a 500' . $m, 'checked' => false),
        array('value' => '501;;10000', 'text' => 'Mas de 500' . $m, 'checked' => false)
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

function build_paginacion($search_params) {
    if ($search_params['total_paginas'] > 1) {
        $html = '<div class="col-md-12">';
        if ($search_params['desde'] < $search_params['hasta']) {
            $html.='<p> Mostrando ' . $search_params['desde'] . ' a ' . $search_params['hasta'];
        } else {
            $html.='<p> Mostrando el ' . $search_params['desde'];
        }
        $html.= ' de ' . $search_params['total'] . ' resultados</p></div>';
        $html.= '</p>';
        $html.= '</div>';

        $html.='<div class="col-md-12">';
        $html.='<div class="paginacion-listado">';
        $html.='<ul class="pagination">';

        if ($search_params['pagina'] - 5 >= 0 && $search_params['total_paginas'] > 7) {
            $html.='<li>';
            $html.='<a data-id="' . $search_params['anterior'] . '" href="' . site_url('pagina/') . '/' . $search_params['anterior'] . '"><</a>';
            $html.='</li>';
        }

        if ($search_params['pagina'] - 3 <= 0) {
            $limit_lower = 1;
            $extra = (($search_params['pagina'] - 3) * -1) + 1;
        } else {
            $limit_lower = $search_params['pagina'] - 3;
            $extra = 0;
        }

        if ($search_params['pagina'] + 3 + $extra >= $search_params['total_paginas']) {
            $limit_upper = $search_params['total_paginas'];
            $limit_lower-=3 - ($search_params['total_paginas'] - $search_params['pagina']);
            if ($limit_lower <= 0 || $search_params["pagina"]<$limit_lower || $search_params['total_paginas']<=7) {
                $limit_lower = 1;
            }
        } else {
            $limit_upper = $search_params['pagina'] + 3 + $extra;
        }

        for ($i = $limit_lower; $i <= $limit_upper; $i++) {
            $class = "";
            if ($i == $search_params['pagina']) {
                $class = "active";
            }

            $html.='<li class="' . $class . '">';
            $html.='<a data-id="' . $i . '" href="' . site_url('pagina/') . '/' . $i . '">' . $i . '</a>';
            $html.='</li>';
        }

        if ($search_params['pagina'] + 3 <= $search_params['total_paginas'] && $search_params['total_paginas'] > 7) {
            $html.='<li>';
            $html.='<a data-id="' . $search_params['siguiente'] . '" href="' . site_url('pagina/') . '/' . $search_params['siguiente'] . '">></a>';
            $html.='</li>';
        }


        $html.='</ul>';
        $html.='</div>';
        $html.='</div>';

        return $html;
    } else {
        return "";
    }
}
