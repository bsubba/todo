<?php

Class CRUD_model extends CI_Model
{
    protected $_table = null;
    protected $_primary_key = null;
    
    public function __construct() {
        parent::__construct();
    }
    /*
     * @usage
     * All   : $this->user_model->get();
     * Single: $this->user_model->get(2);
     * Custom: $this->user_model->get(array('any'=>'param'));
     * 
     *      */
    //-------------------------------------------------------------------------------------------------
        public function get($id = null, $order_by = null){
            
            if (is_numeric($id)) {
                $this->db->where($this->_primary_key, $id);
            }
            if(is_array($id)){
                foreach($id as $_key => $_value){
                    $this->db->where($_key, $_value);
                }                  
            }
            $q = $this->db->get($this->_table);
            return $q->result_array();
        }
        //-------------------------------------------------------------------------------------------------
         /*
         * @usage
         * $result = $this->user_model->insert(['login'=>'Richard']);
         */
        public function insert($data){
            $this->db->insert($this->_table,$data);
            return $this->db->insert_id();
        }
        //-------------------------------------------------------------------------------------------------
         /*
         * @usage
         * $result = $this->user_model->update(['login'=>'Richard'],3);
         * $result = $this->user_model->update(['login'=>'Richard'],['date_created'=>'0']);
         */
        
        public function update($new_data, $where){
            if(is_numeric($where)){
                $this->db->where($this->_primary_key, $where);
            }
            elseif(is_array($where)){
                foreach($where as $_key => $_value){
                    $this->db->where($_key, $_value);
                }
            }else{
                die("You must pass parameter to the UPDATE() method");
            }
            $this->db->update($this->_table,$new_data);
            return $this->db->affected_rows();
        }
         //-------------------------------------------------------------------------------------------------
        /*
         * @usage
         * $result = $this->user_model->insertUpdate(['name'=>'Ted'],2);
         */
        
        public function insertUpdate($data, $id=false){
            if(!$id){
                die('You must pass second parameter of the insertUpdate() method');
            }
            
            $this->db->select($this->_primary_key);
            $this->db->where($this->_primary_key, $id);
            $q = $this->db->get($this->_table);
            $result = $q->num_rows();
            if($result==0){
                //Insert
                return $this->insert($data);
            }
            return $this->update($data, $id);
                    
        }
        //-------------------------------------------------------------------------------------------------
        /*
         * @usage
         * $result = $this->user_model->delete(array('login'=>'Richard');
         */
        
        public function delete($id){
            if(is_numeric($id)){
                 $this->db->where($this->_primary_key, $id);
            }
            elseif(is_array($id)){
                foreach($id as $_key => $_value){
                    $this->db->where($_key, $_value);
                }
            }else{
                die("You must pass parameter to the DELETE() method");
            }
            $this->db->delete($this->_table);
            return $this->db->affected_rows();
        }
        //-------------------------------------------------------------------------------------------------
}

