<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

// Load the MX_Controller class
require APPPATH . 'third_party/MX/Controller.php';

class MY_Controller extends MX_Controller {

    private $_ci;

    public function __construct() {
        parent::__construct();
        $this->_ci = & get_instance();
        $this->template->add_metadata("keywords", "Comparador,Productos,Infocompras,Social");
        $this->template->add_metadata("distribution", "global");
        $this->template->add_metadata("robots", "all");
    }

    /**
     * 
     */
    public function show_profiler() {
        $this->output->enable_profiler(TRUE);
    }

    public function ajax_header() {
        $this->output->set_header("HTTP/1.0 200 OK");
        $this->output->set_header("HTTP/1.1 200 OK");
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
        $this->output->set_header("Cache-Control: post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    /**
     * Load Javascript inside the page's body
     * @access  public
     * @param   string  $script
     */
    public function _load_script($script) {
        if (isset($this->_ci->template) && is_object($this->_ci->template)) {
            // Queue up the script to be executed after the page is completely rendered
            echo <<< JS
<script>
    var CIS = CIS || { Script: { queue: [] } };
    CIS.Script.queue.push(function() { $script });
</script>
JS;
        } else {
            echo '<script>' . $script . '</script>';
        }
    }

}

class Ajax_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->library('response');
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */