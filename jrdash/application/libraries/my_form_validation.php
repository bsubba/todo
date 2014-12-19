<?php

class My_Form_validation extends CI_Form_validation
{
    public function __construct() {
        parent::__construct();
    }
    
    public function error_array()
    {
        if(count($this->_error_array)>0){
            return $this->_error_array;
        }
        
    }
    
}

