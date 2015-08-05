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
    $text = trim($text);
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

function truncate_simple($text, $chars = 25) {
    $flag = false;
    if (strlen($text) > $chars) {
        $flag = true;
    }

    $text = $text . " ";
    $text = substr($text, 0, $chars);

    if ($flag) {
        $text = $text . "...";
    }

    return $text;
}

function keywords_listado() {
    $data = array(
        'Alimentación' => 'Alimentación',
        'Hogar' => 'Hogar',
        'Moda y Belleza' => 'Moda y Belleza',
        'Tecnologia y Motor' => 'Tecnologia y Motor',
        'Campo y Mar' => 'Campo y Mar',
        'Deporte y Diversión' => 'Deporte y Diversión',
        'Servicios' => 'Servicios',
        'Suministros Industriales y Profesionales' => 'Suministros Industriales y Profesionales',
        'Otros' => 'Otros'
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

function blacklisted_words($word) {
    $list = array("login", "logout", "registro", "buscar", "buscar_producto", "vendedores", "registro_exitoso", "registrar_cliente", "registrar_vendedor", "seguros", "usuarios",
        "acceso_invalido", "buscar_prestadores", "password", "util", "panel_vendedor", "admin");

    if (in_array($word, $list)) {
        return true;
    } else {
        return false;
    }
}

function truncate_html($text, $length = 100, $options = array()) {
    $default = array(
        'ending' => '...', 'exact' => true, 'html' => false
    );
    $options = array_merge($default, $options);
    extract($options);

    if ($html) {
        if (mb_strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
            return $text;
        }
        $totalLength = mb_strlen(strip_tags($ending));
        $openTags = array();
        $truncate = '';

        preg_match_all('/(<\/?([\w+]+)[^>]*>)?([^<>]*)/', $text, $tags, PREG_SET_ORDER);
        foreach ($tags as $tag) {
            if (!preg_match('/img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param/s', $tag[2])) {
                if (preg_match('/<[\w]+[^>]*>/s', $tag[0])) {
                    array_unshift($openTags, $tag[2]);
                } else if (preg_match('/<\/([\w]+)[^>]*>/s', $tag[0], $closeTag)) {
                    $pos = array_search($closeTag[1], $openTags);
                    if ($pos !== false) {
                        array_splice($openTags, $pos, 1);
                    }
                }
            }
            $truncate .= $tag[1];

            $contentLength = mb_strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', ' ', $tag[3]));
            if ($contentLength + $totalLength > $length) {
                $left = $length - $totalLength;
                $entitiesLength = 0;
                if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|&#x[0-9a-f]{1,6};/i', $tag[3], $entities, PREG_OFFSET_CAPTURE)) {
                    foreach ($entities[0] as $entity) {
                        if ($entity[1] + 1 - $entitiesLength <= $left) {
                            $left--;
                            $entitiesLength += mb_strlen($entity[0]);
                        } else {
                            break;
                        }
                    }
                }

                $truncate .= mb_substr($tag[3], 0, $left + $entitiesLength);
                break;
            } else {
                $truncate .= $tag[3];
                $totalLength += $contentLength;
            }
            if ($totalLength >= $length) {
                break;
            }
        }
    } else {
        if (mb_strlen($text) <= $length) {
            return $text;
        } else {
            $truncate = mb_substr($text, 0, $length - mb_strlen($ending));
        }
    }
    if (!$exact) {
        $spacepos = mb_strrpos($truncate, ' ');
        if (isset($spacepos)) {
            if ($html) {
                $bits = mb_substr($truncate, $spacepos);
                preg_match_all('/<\/([a-z]+)>/', $bits, $droppedTags, PREG_SET_ORDER);
                if (!empty($droppedTags)) {
                    foreach ($droppedTags as $closingTag) {
                        if (!in_array($closingTag[1], $openTags)) {
                            array_unshift($openTags, $closingTag[1]);
                        }
                    }
                }
            }
            $truncate = mb_substr($truncate, 0, $spacepos);
        }
    }
    $truncate .= $ending;

    if ($html) {
        foreach ($openTags as $tag) {
            $truncate .= '</' . $tag . '>';
        }
    }

    return $truncate;
}

function SimpleXML2Array($xml) {
    $array = (array) $xml;

    //recursive Parser
    foreach ($array as $key => $value) {
        if (is_object($value)) {
            if (strpos(get_class($value), "SimpleXML") !== false) {
                $array[$key] = SimpleXML2Array($value);
            }
        } elseif (is_array($value)) {
            $array[$key] = SimpleXML2Array($value);
        }
    }

    return $array;
}

function print_ejemplo($ex, $ext = 'xml') {
    $file = APPPATH . 'modules/webservice/views/examples/' . $ex . '.' . $ext;
    if (!is_file($file)) {
        highlight_string('No se encuentra el ejemplo asociado');
        return;
    }
    highlight_file($file);
}
