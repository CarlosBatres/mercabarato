<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$config['producto'] = array(
    'upload_dir' => absolute_path() . '/assets/'.$this->config['productos_img_path'],
    'upload_url' => assets_url($this->config['productos_img_path']),
// Defines which files (based on their names) are accepted for upload:
    'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
    // The php.ini settings upload_max_filesize and post_max_size
// take precedence over the following max_file_size setting:
    'max_file_size' => NULL,
    'min_file_size' => 1,
    // Image resolution restrictions:
    'max_width' => NULL,
    'max_height' => NULL,
    'min_width' => 1,
    'min_height' => 1,
    'image_versions' => array(
        '' => array(
            'max_width' => 500,
            'max_height' => 500,
            'jpeg_quality' => 95
        ),
        'thumbnail' => array(            
            'max_width' => 100,
            'max_height' => 100
        )
    )
);

$config['categoria'] = array(
    'upload_dir' => absolute_path() . '/assets/'.$this->config['categorias_img_path'],
    'upload_url' => assets_url($this->config['categorias_img_path']),
// Defines which files (based on their names) are accepted for upload:
    'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
    // The php.ini settings upload_max_filesize and post_max_size
// take precedence over the following max_file_size setting:
    'max_file_size' => NULL,
    'min_file_size' => 1,
    // Image resolution restrictions:
    'max_width' => NULL,
    'max_height' => NULL,
    'min_width' => 1,
    'min_height' => 1,
    'image_versions' => array(
        '' => array(
            'max_width' => 140,
            'max_height' => 140,
            'jpeg_quality' => 95
        ),
        'thumbnail' => array(            
            'max_width' => 50,
            'max_height' => 50
        )
    )
);

$config['vendedor'] = array(
    'upload_dir' => absolute_path() . '/assets/'.$this->config['vendedores_img_path'],
    'upload_url' => assets_url($this->config['vendedores_img_path']),
// Defines which files (based on their names) are accepted for upload:
    'accept_file_types' => '/(\.|\/)(gif|jpe?g|png)$/i',
    // The php.ini settings upload_max_filesize and post_max_size
// take precedence over the following max_file_size setting:
    'max_file_size' => NULL,
    'min_file_size' => 1,
    // Image resolution restrictions:
    'max_width' => NULL,
    'max_height' => NULL,
    'min_width' => 1,
    'min_height' => 1,
    'image_versions' => array(
        '' => array(
            'max_width' => 300,
            'max_height' => 300,
            'jpeg_quality' => 95
        ),
        'thumbnail' => array(            
            'max_width' => 50,
            'max_height' => 50
        )
    )
);

/* End of file upload.php */
/* Location: ./application/config/upload.php */