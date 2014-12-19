<?php

    class Test extends CI_Controller{
        
        public function __construct() {
            parent::__construct();
            $this->load->model('user_model');
            //$result = $this->user_model->get(array("user_id"=>9,"login"=>"mingsu"));
          // $result = $this->user_model->get();
            //$result = $this->user_model->insert(['login'=>'Richard']);
           
            
            //$result = $this->user_model->delete(15);
           // $result = $this->user_model->delete(array('login'=>'Richard'));
            //$result = $this->user_model->update(array('login'=>'Richard','password'=>'hello'),14);
            //$result = $this->user_model->update(array('login'=>'Richard','password'=>'hell'),array('login'=>'Richard'));
            $result = $this->user_model->insertUpdate(['login'=>'Harish'],14);
            echo '<pre>';
            print_r($result);
        }
        public function index(){
            $this->output->enable_profiler(true);
        }
        
        public function get(){
            $result = $this->user_model->get();
            print_r($result);
            $this->output->enable_profiler();
        }
        /*
         * @usage
         * $result = $this->user_model->insert(['login'=>'Richard']);
         */
        public function insert($data){
            //$data = ['login' => 'Rohan','password'=>'test'];
            //$result =  $this->user_model->insert($data);
            $this->db->insert($this->_table,$data);
            return $this->db->insert_id();
        }
        
        public function update(){
            $data = ['login'=>'Nirmal'];
            $result = $this->user_model->update($data,4);
            print_r($result);
        }
        
        public function delete(){
            $result = $this->user_model->delete(5);
            print_r($result);
        }
    }


