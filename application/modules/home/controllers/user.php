<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
    }
    
    public function login() {        
        $formValues = $this->input->post();
        
        if ($formValues !== false) {            
            $data['password'] = $this->input->post('password');
            $data['email'] = $this->input->post('email');
        }
    }

}
