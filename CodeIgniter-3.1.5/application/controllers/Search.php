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
			date_default_timezone_set("UTC");
			
			$this->db->select('ADS.ad_id, item_description, ad_title, item_condition, item_price, post_date, user_name, brand_name, image_location, city, province, category_name, USERS.user_name');
			$this->db->from('ADS');
			$this->db->join('USERS', 'ADS.user_id = USERS.user_id');
			$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id');
			$this->db->join('MANUFACTURERS', 'BRANDS.manufacturer_id = MANUFACTURERS.manufacturer_id');
			$this->db->join('IMAGES', 'ADS.ad_id = IMAGES.ad_id');
			$this->db->join('CATEGORIES', 'ADS.category_id = CATEGORIES.category_id');
			
			if(isset($_GET['search_string']))
			{
				$this->db->like('ad_title', $this->input->get('search_string', true));
			}
			
			if(isset($_GET['category']))
			{
				if($this->input->get('category', true) != "all")
				{
					$this->db->where('ADS.category_id', $this->input->get('category', true));
				}
			}
			
			if(isset($_GET['low_price']))
			{
				if($this->input->get('low_price', true) != "")
				{
					$this->db->where('item_price >=', $this->input->get('low_price', true));
				}
			}
			
			if(isset($_GET['high_price']))
			{
				if($this->input->get('high_price', true))
				{
					$this->db->where('item_price <=', $this->input->get('high_price', true));
				}
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
				else if($this->input->get('sort', true) == "oldest")
				{
					$this->db->order_by('bump_date ASC');
				}
			}
			else
			{
				$this->db->order_by('bump_date DESC');
			}
			
			$this->db->where('public', 1);
			$this->db->where('reported', 0);
			$this->db->where('sold', 0);
			
			$query = $this->db->get();
			
			if($query)
			{
				$details = $query->result_array();
				/* echo "<pre>";
				print_r($details);
				echo "</pre>"; */
				for($i = 0; $i< $query->num_rows(); $i++)
				{
					$this->TPL['results'][$i]['id'] = $details[$i]['ad_id'];
					$this->TPL['results'][$i]['user'] = $details[$i]['user_name'];
					$this->TPL['results'][$i]['title'] = $details[$i]['ad_title'];
					$this->TPL['results'][$i]['condition'] = $details[$i]['item_condition'];
					$this->TPL['results'][$i]['price'] = $details[$i]['item_price'];
					$this->TPL['results'][$i]['desc'] = $details[$i]['item_description'];
					$this->TPL['results'][$i]['date'] = date("d/m/Y", strtotime($details[$i]['post_date']));
					$this->TPL['results'][$i]['location'] = ucfirst($details[$i]['city']) . ", " . ucfirst($details[$i]['province']);
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
		
		/* echo "<pre>";
		print_r($this->TPL);
		echo "</pre>"; */
		
		$this->template->show('search', $this->TPL);
	}
	
	public function build_search_urls()
	{
		$url = "c=search&m=display";
		
		if(isset($_GET['search_string']))
		{
			$url += "&search_string=" . $this->input->get('search_string', true);
		}
		
		if(isset($_GET['category']))
		{
			$url += "&category=" . $this->input->get('category', true);
		}
		
		if(isset($_GET['low_price']))
		{
			$url += "&low_price=" . $this->input->get('low_price', true);
		}
		
		if(isset($_GET['high_price']))
		{
			$url += "&high_price=" . $this->input->get('high_price', true);
		}
		
		if(isset($_GET['province']))
		{
			$url += "&province=" . $this->input->get('province', true);
		}
		
		if(isset($_GET['city']))
		{
			$url += "&city=" . $this->input->get('city', true);
		}
		
		if(isset($_GET['manufacturer']))
		{
			$url += "&manufacturer=" . $this->input->get('manufacturer', true);
		}
		
		if(isset($_GET['brand']))
		{
			
			$url += "&brand=" . $this->input->get('brand', true);
		}
		
		if(isset($_GET['sort']))
		{
			$url += "&sort=" . $this->input->get('sort', true);
		}
		
		return $url;
	}
	
	private function get_search_modifiers($search_string)
	{
		
		
	}
	
	public function get_cities_json()
	{
		$results;
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$province = $this->input->get('province', true);
			$query = $this->db->query("SELECT DISTINCT `city` FROM `USERS` WHERE LOWER(`province`) LIKE '%$province%';");
			
			if($query)
			{
				$results = $query->result_array();
				
				
				echo json_encode($results);
			}
		}
	}
	
}