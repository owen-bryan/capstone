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
		if($_SERVER['REQUEST_METHOD'] = "GET")
		{
			$this->db->select('ADS.ad_id, ADS.user_id, item_description, ad_title, item_condition, item_price, post_date, user_name, brand_name, image_location');
			$this->db->from('ADS');
			$this->db->join('USERS', 'ADS.user_id = USERS.user_id');
			$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id');
			$this->db->join('IMAGES', 'ADS.ad_id = IMAGES.ad_id');
			
			if(isset($_GET['search_string']))
			{
				$this->db->like('ad_title', $this->input->get('search_string', true));
			}
			
			if($this->input->get('category', true) != "all")
			{
				$this->db->where('ADS.category_id', $this->input->get('category', true));
			}
			
			if(isset($_GET['low_price']) && $_GET['low_price'] != "")
			{
				$this->db->where('item_price >=', $this->input->get('low_price', true));
			}
			
			if(isset($_GET['high_price'])  && $_GET['high_price'] != "")
			{
				$this->db->where('item_price <=', $this->input->get('high_price', true));
			}
			
			if(isset($_GET['brand']))
			{
				$this->db->where('brand_id', $this->input->get('brand', true));
			}
			
			if(isset($_GET['sort']))
			{
				if($this->input->get('sort', true) == "newest")
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
					if($details[$i]['image_location'] != null){
						$this->TPL['results'][$i]['img'] = "https://csunix.mohawkcollege.ca/~000340128/private/capstone-project/CodeIgniter-3.1.5/uploads/" . $details[$i]['image_location'];
						
					}
					else
					{
						$this->TPL['results'][$i]['img'] = "";
					}
				}
			}
		}
		$this->template->show('search', $this->TPL);
	}
}