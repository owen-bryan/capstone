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
		$this->template->show('search', $this->TPL);
	}
	
	public function display()
	{	
		if($_SERVER['REQUEST_METHOD'] = "POST")
		{
			$this->db->select('ad_id, ADS.user_id, item_description, ad_title, item_condition, item_price, post_date, user_name, brand_name');
			$this->db->from('ADS');
			$this->db->join('USERS', 'ADS.user_id = USERS.user_id');
			$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id');
			
			if(isset($_POST['search_string']))
			{
				$this->db->like('ad_title', $this->input->post('search_string', true));
			}
			
			if($this->input->post('category', true) != "all")
			{
				$this->db->where('ADS.category_id', $this->input->post('category', true));
			}
			
			if(isset($_POST['low_price']) && $_POST['low_price'] != "")
			{
				$this->db->where('item_price >=', $this->input->post('low_price', true));
			}
			
			if(isset($_POST['high_price'])  && $_POST['high_price'] != "")
			{
				$this->db->where('item_price <=', $this->input->post('high_price', true));
			}
			
			if(isset($_POST['brand']))
			{
				$this->db->where('brand_id', $this->input->post('brand', true));
			}
			
			if(isset($_POST['sort']))
			{
				if($this->input->post('sort', true) == "newest")
				{
					$this->db->order_by('bump_date DESC');
				}
				
			}
			
			$this->db->where('public', 1);
			$this->db->where('reported', 0);
			$this->db->where('sold', 0);
			
			$query = $this->db->get();
			
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