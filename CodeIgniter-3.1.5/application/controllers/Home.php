<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Home";
		$this->TPL['loggedIn'] = $this->user_auth->validSessionExists();
		
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
		
		
	}
	
	public function index()
	{
		
		$this->template->show('home', $this->TPL);
	}

}