<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Home";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		
		
		
	}
	
	
	private function get_data()
	{
		$query = $this->db->query("SELECT * FROM CATEGORIES;");
		
		if($query)
		{
			$i = 0;
			foreach($query->result_array() as $row)
			{
				$this->TPL['categories'][$i]['id'] = $row['category_id'];
				$this->TPL['categories'][$i]['name'] = $row['category_name'];
				$i++;
			}
		}
		
		$query = $this->db->query("SELECT DISTINCT `province` FROM `USERS` WHERE `banned`= 0");
		
		if($query)
		{
			$i = 0;
			foreach($query->result_array() as $row)
			{
				$this->TPL['provinces'][$i] = $row['province'];
				$i++;
			}
		}
		
		$query = $this->db->query("SELECT `manufacturer_id`, `manufacturer_name` FROM `MANUFACTURERS`");
		
		if($query)
		{
			$i = 0;
			foreach($query->result_array() as $row)
			{
				$this->TPL['manufacturers'][$i]['name'] = $row['manufacturer_name'];
				$this->TPL['manufacturers'][$i]['id'] = $row['manufacturer_id'];
				$i++;
			}
		}
		
		// echo "<pre>";
		// print_r($this->TPL);
		// echo "</pre>";
		
	}
	
	public function index()
	{
		$this->get_data();
		$this->template->show('home', $this->TPL);
	}

}