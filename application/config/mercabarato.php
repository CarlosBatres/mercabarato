<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config["emails_enabled"]=false;

$config["site_info_email"]="info@mercabarato.com";
$config["site_baja_email"]="baja@mercabarato.com";
$config["site_comercial_email"]="comercial@mercabarato.com";

$config['email_info'] = array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.googlemail.com',
    'smtp_user' => 'username',
    'smtp_pass' => 'pass',
    'smtp_port' => '465',
    'mailtype' => 'html'
);

