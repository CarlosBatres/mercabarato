<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function vendedor_actividad_dropdown($pos = null) {
    $data = array(
        'No Especificada' => 'Actividad',
        'Moda y Complementos' => 'Moda y Complementos',
        'Salud, ortopedia y belleza' => 'Salud, ortopedia y belleza',
        'Agropecuaria y Pesca' => 'Agropecuaria y Pesca',
        'Motor y Accesorios' => 'Motor y Accesorioas',
        'Edición y Artes Gráficas' => 'Edición y Artes Gráficas',
        'Alimentación y Bebidas' => 'Alimentación y Bebidas',
        'Decoración' => 'Decoración',
        'Química, Limpieza e Higiene' => 'Química, Limpieza e Higiene',
        'Salud, Ortopedia y Belleza' => 'Salud, Ortopedia y Belleza',
        'Regalos, Disfraces y Juegos' => 'Regalos, Disfraces y Juegos',
        'Oficina, Lectura y Escuela' => 'Oficina, Lectura y Escuela',
        'Maquinaria y Suministros Industriales' => 'Maquinaria y Suministros Industriales',
        'Ocio, Deportes y Aficiones' => 'Ocio, Deportes y Aficiones',
        'Puericultura y Premamá' => 'Puericultura y Premamá',
        'Servicios Varios' => 'Servicios Varios',
        'Turismo, Alojamiento y Hostelería' => 'Turismo, Alojamiento y Hostelería',
        'Transporte' => 'Transporte',
        'Seguros' => 'Seguros'
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
        array('value' => '0;;15', 'text' => 'Menos de 15 ' . $m, 'checked' => false),
        array('value' => '16;;50', 'text' => 'Desde 16 ' . $m . ' hasta 50 ' . $m, 'checked' => false),
        array('value' => '51;;100', 'text' => 'Desde 51 ' . $m . ' hasta 100 ' . $m, 'checked' => false),
        array('value' => '101;;500', 'text' => 'Desde 101 ' . $m . ' hasta 500 ' . $m, 'checked' => false),
        array('value' => '501;;10000', 'text' => 'Mas de 500 ' . $m, 'checked' => false)
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
            if ($limit_lower <= 0 || $search_params["pagina"] < $limit_lower || $search_params['total_paginas'] <= 7) {
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

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'año',
        'm' => 'mes',
        'w' => 'semana',
        'd' => 'dia',
        'h' => 'hora',
        'i' => 'minuto',
        's' => 'segundo',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $suff = ($v == "mes") ? 'es' : 's';
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? $suff : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full)
        $string = array_slice($string, 0, 1);
    return $string ? 'Hace ' . implode(', ', $string) : 'Este momento';
}

function truncate($text, $chars = 25) {
    $flag = false;
    if (strlen($text) > $chars) {
        $flag = true;
    }
    $text = $text . " ";
    $text = substr($text, 0, $chars);
    $text = substr($text, 0, strrpos($text, ' '));

    if ($flag) {
        $text = $text . "...";
    }

    return $text;
}

function keywords_listado() {
    $data = array(
        'Construcción' => 'Construcción',
        'Moda' => 'Moda',
        'Tecnologia' => 'Tecnologia',
        'Salud y Belleza' => 'Salud y Belleza',
        'Casa y Jardin' => 'Casa y Jardin',
        'Inmobiliaria' => 'Inmobiliaria',
        'Mascotas' => 'Mascotas',
        'Limpieza e Higiene' => 'Limpieza e Higiene',
        'Artes Graficas' => 'Artes Graficas',
        'Servicios' => 'Servicios',
        'Regalos' => 'Regalos',
        'Disfraces' => 'Disfraces',
        'Motor' => 'Motor',
        'Alimentación' => 'Alimentación',
        'Suministros Industriales' => 'Suministros Industriales',
        'Musica' => 'Musica',
        'Internet' => 'Internet'
    );
    return $data;
}

function fix_category_text($text) {
    $array = explode(" ", $text);
    $final = "";
    foreach ($array as $word) {
        if (strlen($word) > 1) {
            $final.= mb_convert_case(strtolower($word), MB_CASE_TITLE, "UTF-8");
        } else {
            $final.= $word;
        }
        $final.=" ";
    }
    
    return trim($final, " ");
}
