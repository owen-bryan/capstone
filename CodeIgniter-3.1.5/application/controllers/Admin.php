<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Admin";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		$this->TPL['admin'] = $this->ion_auth->is_admin();
		
		if($this->TPL['admin'] == false || $this->TPL['loggedIn'] == false)
		{
			redirect("c=home");
		}
	}
	
	public function index()
	{
		
		$this->template->show('admin', $this->TPL);
		
	}
	
	public function manufacturer()
	{
		$this->template->show('new_manufacturer', $this->TPL);
	}
	
	public function new_manufacturer()
	{
		if(trim($this->input->post("manufacturer", true)) != "")
		{
			$manufacturer = trim($this->input->post("manufacturer", true));
			$exists = $this->db->like('manufacturer_name', $manufacturer)
						->limit(1)
						->from("MANUFACTURERS")
						->count_all_results() > 0;
			if($exists == false)
			{
				$query = $this->db->insert("MANUFACTURERS", array("manufacturer_name"=>$manufacturer));
				
				if($query)
				{
					$this->TPL['success'] = true;
					$this->TPL['success_msg'] = "Manufacturer successfully added to Database";
					
					$this->manufacturer();
				}
				else
				{
					$this->TPL['error'] = true;
					$this->TPL['error_msg'] = "Manufacturer not successfully added to Database";
					
					$this->manufacturer();
				}
			}
			else
				{
					$this->TPL['error'] = true;
					$this->TPL['error_msg'] = "Manufacturer already in Database";
					
					$this->manufacturer();
				}
		}
	}

}