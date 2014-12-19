<?php

    
class Api extends CI_Controller{
    //-------------------------------------------------------------------------------------------------    
    public function __construct() 
    {
         parent::__construct();
         $this->load->model('user_model');
         $this->load->model('todo_model');
         $this->load->model('note_model');

    }
    //-------------------------------------------------------------------------------------------------
    private function _require_login()
    {
        if($this->session->userdata('user_id') == false)
        {
           $this->output->set_output(json_encode(['result'=>0, 'error' => 'You are not authorised.']));
        }
    }
    //-------------------------------------------------------------------------------------------------
    public function register(){
            $this->output->set_content_type('applicaiton_json');
            
            $this->form_validation->set_rules('login','Login','required|min_length[4]|max_length[16]|is_unique[user.login]');
            $this->form_validation->set_rules('email','Email','required|valid_email|is_unique[user.email]');
            $this->form_validation->set_rules('password','Password','required|min_length[4]|max_length[16]|matches[confirm-password]');
           // $this->form_validaiton->set_message('required','This field cannot be empty');
            $this->form_validation->set_message('required','This field cannot be empty');
            $this->form_validation->set_message('valid_email','Please enter the valid email');
            if($this->form_validation->run() == false){
                $this->output->set_output(json_encode(['result'=>0,'error'=> $this->form_validation->error_array()]));
                return false;
            }
            
            $login = $this->input->post('login');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm-password');
            
            $user_id = $this->user_model->insert([
                'login' => $login,
                'email' => $email,
                'password' => hash('sha256',$password.SALT)               
            ]);
           
            if($user_id){
                $this->session->set_userdata(['user_id' => $user_id]);
                $this->output->set_output(json_encode(['result'=>1]));
                return false ;              
            }
            
            $this->output->set_output(json_encode(['result'=>0, 'error' => 'User could not be created']));
            
        }
        //-------------------------------------------------------------------------------------------------
        public function login(){
            
            $login = $this->input->post('login');
            $password = $this->input->post('password');
            
            $result = $this->user_model->get([
                'login' => $login, 
                'password' => hash('sha256',$password.SALT)
            ]);
            
            $this->output->set_content_type('applicaiton_json');
            if($result){
                $this->session->set_userdata(['user_id' => $result[0]['user_id']]);
                $this->output->set_output(json_encode(['result'=>1]));
                return false ;              
            }
            $this->output->set_output(json_encode(['result'=>0]));
        }
        
         //-------------------------------------------------------------------------------------------------
         
         public function get_todo($id=null){
             $this->_require_login();
             if($id!=null){
                 $result = $this->todo_model->get([
                     'todo_id' => $id,
                     'user_id' => $this->session->userdata('user_id')
                 ]);
                 
             }else{
                 $result = $this->todo_model->get([
                     'user_id' => $this->session->userdata('user_id')
                 ]);
             }
             
             $this->output->set_output(json_encode($result));
             
         }
         
        //-------------------------------------------------------------------------------------------------
         
        public function create_todo()
        {
            $this->_require_login();
            //form validation
            $this->form_validation->set_rules('content','Content','required|max_length[255]');
            if($this->form_validation->run()==false){
                $this->output->set_output(json_encode([
                    'result' => 0,
                    'error' => $this->form_validation->error_array()
                    ]));
                return false;
            }
            $result = $this->todo_model->insert([
                'content' => $this->input->post('content'),
                'user_id' => $this->session->userdata('user_id')
            ]);
            if($result){
                //Get the fresh entry for the DOM               
                $this->output->set_output(json_encode([ 
                    'result' => 1,
                    'data' => array(
                        'todo_id' => $result,
                        'content' => $this->input->post('content'),
                        'completed'=>0
                    )
                    ]));
                return false;
            }
            $this->output->set_output(json_encode(['result' => 0,'error'=>'could not insert record']));
        }
        //-------------------------------------------------------------------------------------------------
        public function update_todo()
        {
            $this->_require_login();
            $todo_id = $this->input->post('todo_id');
            $completed = $this->input->post('completed');
            $this->db->where(['todo_id'=>$todo_id]);
            $result = $this->todo_model->update([
                        'completed'=>$completed
            ], $todo_id);
           
            if($result){
                $this->output->set_output(json_encode(['result'=>1]));
                return false;
            }
            $this->output->set_output(json_encode(['result'=>0]));
            
        }
        //-------------------------------------------------------------------------------------------------
        public function delete_todo()
        {
            $this->_require_login();
            $result = $this->todo_model->delete([
                'todo_id'=>$this->input->post('todo_id'),
                'user_id'=>$this->session->userdata('user_id')
            ]); 
            if($result){
                $this->output->set_output(json_encode(['result' => 1]));
                return false;
            }
            $this->output->set_output(json_encode([
                'result' => 0,
                'message'=> 'Could not delete'
                ]));
            
        }
        //-------------------------------------------------------------------------------------------------
        public function get_note($id=null)
        {
            $this->_require_login();
             if($id!=null){
                 $result = $this->note_model->get([
                     'note_id' => $id,
                     'user_id' => $this->session->userdata('user_id')
                 ]);
                 
             }else{
                 $result = $this->note_model->get([
                     'user_id' => $this->session->userdata('user_id')
                 ]);
             }
             
             $this->output->set_output(json_encode($result));
        }
        //-------------------------------------------------------------------------------------------------
        //-------------------------------------------------------------------------------------------------
        public function create_note()
        {
            $this->_require_login();
             //form validation
            $this->form_validation->set_rules('title','Tite','required|max_length[50]');
            $this->form_validation->set_rules('content','Content','required|max_length[500]');
            if($this->form_validation->run()==false){
                $this->output->set_output(json_encode([
                    'result' => 0,
                    'error' => $this->form_validation->error_array()
                    ]));
                return false;
            }
            $result = $this->note_model->insert([
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'user_id' => $this->session->userdata('user_id')
            ]);
            if($result){
                //Get the fresh entry for the DOM               
                $this->output->set_output(json_encode([
                    'result' => 1,
                    'data' => array(
                        'note_id' => $result,
                        'title' => $this->input->post('title'),
                        'content' => $this->input->post('content')
                    )
                    ]));
                return false;
            }
            $this->output->set_output(json_encode(['result' => 0,'error'=>'could not insert record']));
        }
        //-------------------------------------------------------------------------------------------------
        public function update_note()
        {
            $this->_require_login();
            $note_id = $this->input->post('note_id');
           
            $result = $this->note_model->update([
                        'title' => $this->input->post('title'),
                        'content' =>  $this->input->post('content')
            ], $note_id);
           
            $this->output->set_output(json_encode(['result'=>1]));
        }
        //-------------------------------------------------------------------------------------------------
        public function delete_note()
        {
            $this->_require_login();
            $result = $this->note_model->delete([
                'note_id'=>$this->input->post('note_id'),
                'user_id'=>$this->session->userdata('user_id')
            ]); 
            if($result){
                $this->output->set_output(json_encode(['result' => 1]));
                return false;
            }
            $this->output->set_output(json_encode([
                'result' => 0,
                'message'=> 'Could not delete'
                ]));
        }
        //-------------------------------------------------------------------------------------------------
           
}

