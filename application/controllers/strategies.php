<?php
class Strategies extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('strategies_model');
		$this->load->helper('url');
		
		
	}

	public function index() {
	  $data['user'] = $this->session->all_userdata();
		
		$data['strategies'] = $this->strategies_model->get_strategies();
		$data['title'] = 'Bike Plan Strategies';

  	$this->load->view('templates/header', $data);
  	$this->load->view('strategies/index', $data);
  	$this->load->view('templates/footer');
		
	}

	public function view($id) {
		$data['strategy'] = $this->strategies_model->get_strategy($id);
		$this->load->view('strategies/view', $data);
	}
}