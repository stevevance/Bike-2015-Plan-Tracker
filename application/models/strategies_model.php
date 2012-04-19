<?php
class Strategies_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}
	
	public function get_strategies() {
		$query = $this->db->get('strategies');
		return $query->result_array();
  }
  
  public function get_strategy($id) {
  	$query = $this->db->get_where('strategies', array('id' => $id));
  	return $query->row_array();
  }
}