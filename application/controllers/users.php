<?php
class Users extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('strategies_model');
		$this->load->helper('url');
	}

	public function register() {
	  // TODO: Make this better
		$this->simpleloginsecure->create('bensheldon@gmail.com', 'password');
	  redirect('users/login'); 
	}

	public function login() {
	  
	  $this->form_validation->set_rules('email', 'Email', 'required');
  	
  	if ($this->form_validation->run() === FALSE) {
  		$this->load->view('templates/header');	
  		$this->load->view('users/login');
  		$this->load->view('templates/footer');
  	}
  	else {
  	  // Try to Login with
  	  $email = $this->input->post('email');
  	  $password = $this->input->post('password');
  	  
  	  if ($this->simpleloginsecure->login($email, $password)) {
        // redirect to strategies page
        redirect('strategies/index'); 
      }
      else {
        $this->form_validation->set_rules('password', 'Password', 'is wrong');
    	  $this->load->view('templates/header');	
    		$this->load->view('users/login');
    		$this->load->view('templates/footer');
      }
  	}
	}
	
	public function logout() {
	  $this->simpleloginsecure->logout();
	  redirect('strategies/index'); 
	}
}