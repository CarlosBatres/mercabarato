<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mantenimiento
{
   var $CI;    
   public function mantenimiento()
   {
      $this->CI =& get_instance();
      $this->CI->load->config("mantenimiento");    
      if(config_item("sitio_mantenimiento"))
      {
          $_error =& load_class('Exceptions', 'core');
          echo $_error->show_error("", "", 'error_mantenimiento', 200);
          exit;
      }
   }
}