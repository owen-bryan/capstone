<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Search";
		$this->TPL['loggedIn'] = $this->user_auth->validSessionExists();
		

	}
	
	public function index()
	{
		if($_SERVER['REQUEST_METHOD'] = "POST"){
			$sql = "SELECT `ad_id`, `ADS`.`user_id`, `item_description`, `ad_title`, `item_condition`, `item_price`, `post_date`,`user_name` FROM `ADS` JOIN `USERS` ON `ADS`.`user_id` = `USERS`.`user_id` WHERE `ad_title` = ? AND `public` = 1 AND `reported` = 0 AND `sold` = 0";
			$query = $this->db->query($sql, $this->input->post('search_string', true));
			
			if($query)
			{
				$details = $query->result_array();
				for($i = 0; $i< $query->num_rows(); $i++)
				{
					$this->TPL['results'][$i]['id'] = $details[$i]['user_id'];
					$this->TPL['results'][$i]['title'] = $details[$i]['ad_title'];
					$this->TPL['results'][$i]['condition'] = $details[$i]['item_condition'];
					$this->TPL['results'][$i]['price'] = $details[$i]['item_price'];
					$this->TPL['results'][$i]['desc'] = $details[$i]['item_description'];
					$this->TPL['results'][$i]['date'] = $details[$i]['post_date'];
					$this->TPL['results'][$i]['location'] = $details[$i]['item_condition'];
					$this->TPL['results'][$i]['img'] = "";
				}
			}
		}
		$this->template->show('search', $this->TPL);
	}
	
	public function search($search_string)
	{	
		if($_SERVER['REQUEST_METHOD'] = "GET"){
			$sql = "SELECT `ad_id`, `ADS`.`user_id`, `item_description`, `ad_title`, `item_condition`, `item_price`, `post_date`,`user_name` FROM `ADS` JOIN `USERS` ON `ADS`.`user_id` = `USERS`.`user_id` WHERE `ad_title` = ? AND `public` = 1 AND `reported` = 0 AND `sold` = 0";
			$query = $this->db->query($sql, $this->input->get('search_string', true));
			
			if($query)
			{
				$details = $query->result_array();
				for($i = 0; $i< $query->num_rows(); $i++)
				{
					$this->TPL['results'][$i]['id'] = $details[$i]['user_id'];
					$this->TPL['results'][$i]['title'] = $details[$i]['ad_title'];
					$this->TPL['results'][$i]['condition'] = $details[$i]['item_condition'];
					$this->TPL['results'][$i]['price'] = $details[$i]['item_price'];
					$this->TPL['results'][$i]['desc'] = $details[$i]['item_description'];
					$this->TPL['results'][$i]['date'] = $details[$i]['post_date'];
					$this->TPL['results'][$i]['location'] = $details[$i]['item_condition'];
					$this->TPL['results'][$i]['img'] = "";
				}
			}
		}
		$this->template->show('search', $this->TPL);
	}
}