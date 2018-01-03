<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Search";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		
		if(isset($_GET['search_string']))
		{
			$this->TPL['search_string'] =  urldecode($this->input->get("search_string", true));
		}
		
		if(isset($_GET['category']))
		{
			$this->TPL['category'] = urldecode($this->input->get("category", true));
		}

		if(isset($_GET['condition']))
		{
			$this->TPL['condition'] = urldecode($this->input->get("condition", true));
		}
		
		if(isset($_GET['manufacturer']))
		{
			$this->TPL['manufacturer'] = urldecode($this->input->get("manufacturer", true));
		}
		
		if(isset($_GET['brand']))
		{
			$this->TPL['brand'] = urldecode($this->input->get("brand", true));
		}
		
		if(isset($_GET['low_price']))
		{
			$this->TPL['low_price'] =  urldecode($this->input->get("low_price", true));
		}
		if(isset($_GET['high_price']))
		{
			$this->TPL['high_price'] =  urldecode($this->input->get("high_price", true));
		}
		if(isset($_GET['province']))
		{
			$this->TPL['province'] =  urldecode($this->input->get("province", true));
		}
		if(isset($_GET['city']))
		{
			$this->TPL['city'] =  urldecode($this->input->get("city", true));
		}
	}
	
	public function index()
	{
		$this->template->show('search', $this->TPL);
	}
	
	public function display()
	{	
		if($_SERVER['REQUEST_METHOD'] = "GET")
		{
			
			$this->db->select('ADS.ad_id, item_description, ad_title, item_condition, item_price, post_date, user_name, brand_name, image_location, city, province, category_name, USERS.user_name');
			$this->db->from('ADS');
			$this->db->join('USERS', 'ADS.user_id = USERS.id');
			$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id');
			$this->db->join('MANUFACTURERS', 'BRANDS.manufacturer_id = MANUFACTURERS.manufacturer_id');
			$this->db->join('IMAGES', 'ADS.ad_id = IMAGES.ad_id');
			$this->db->join('CATEGORIES', 'ADS.category_id = CATEGORIES.category_id');
			
			if(isset($_GET['search_string']))
			{
				$this->db->like('ad_title', $this->TPL['search_string']);
			}
			
			if(isset($_GET['category']))
			{
				if($this->input->get('category', true) != "all")
				{
					$this->db->where('category_name', $this->TPL['category']);
				}
			}
			
			if(isset($_GET['province']))
			{
				if($this->input->get("province", true) != "")
				{
					$this->db->where('province', $this->TPL['province']);
				}
			}
			
			if(isset($_GET['city']))
			{
				if($this->input->get("city", true) != "")
				{
					$this->db->where('city', $this->TPL['city']);
				}
			}
			
			if(isset($_GET['condition']))
			{
				if($this->input->get('condition', true) != "")
				{
					$this->db->where('item_condition', $this->TPL['condition']);
				}
			}
			
			if(isset($_GET['low_price']))
			{
				if($this->input->get('low_price', true) != "")
				{
					$this->db->where('item_price >=', $this->TPL['low_price']);
				}
			}
			
			if(isset($_GET['high_price']))
			{
				if($this->input->get('high_price', true) != "")
				{
					$this->db->where('item_price <=', $this->TPL['high_price']);
				}
			}
			
			if(isset($_GET['brand']))
			{
				$this->db->where('ADS.brand_id', $this->TPL['brand']);
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
					
					$this->build_search_url();
					if(!$this->input->get("province", true))
					{
						$this->get_provinces();
					}
					if($this->input->get("province", true) && !$this->input->get("city", true))
					{
						$this->get_cities();
					}
					if(!$this->input->get("category",true) || strtolower($this->TPL['category']) == "all")
					{
						$this->get_categories();
					}
					if(!$this->input->get("condition",true))
					{
						$this->get_condition();
					}
					
				}
			}
		}
		
		echo "<pre>";
		print_r($this->TPL);
		//print_r($_SESSION);
		//print_r($this->ion_auth->get_users_groups($user->id)->result());
		echo "</pre>";
		
		$this->template->show('search', $this->TPL);
	}
	
	private function build_search_url()
	{
		$url = "c=search&m=display";
		
		if(isset($_GET['search_string']))
		{
			if($this->input->get('search_string', true) != "")
			{	
				$url = $url . "&search_string=" . $this->input->get('search_string', true);
			}
		}
		
		if(isset($_GET['category']))
		{
			if($this->input->get('category', true) != "" && $this->input->get('category', true) != "all")
			{
				$url = $url . "&category=" . $this->input->get('category', true);
			}
			
		}if(isset($_GET['condition']))
		{
			if($this->input->get('condition', true) != "" && $this->input->get('condition', true) != "all")
			{
				$url = $url . "&condition=" . $this->input->get('condition', true);
			}
		}
		
		if(isset($_GET['low_price']))
		{
			if($this->input->get('low_price', true) != ""  && is_numeric($this->input->get('low_price', true)) == true)
			{
				$url = $url . "&low_price=" . $this->input->get('low_price', true);
			}
		}
		
		if(isset($_GET['high_price']))
		{
			if($this->input->get('high_price', true) != "" && is_numeric($this->input->get('high_price', true)) == true)
			{
				$url = $url . "&high_price=" . $this->input->get('high_price', true);
			}
		}
		
		if(isset($_GET['province']))
		{
			if($this->input->get('province', true) != "" && $this->input->get('province', true) != "all")
			{
				$url = $url . "&province=" . $this->input->get('province', true);
			}
			
		}
		
		if(isset($_GET['city']))
		{
			if($this->input->get('city', true) != "" && $this->input->get('city', true) != "all")
			{
				$url = $url . "&city=" . $this->input->get('city', true);
			}
			
		}
		
		if(isset($_GET['manufacturer']))
		{
			if($this->input->get('manufacturer', true) != "" && $this->input->get('manufacturer', true) != "all")
			{
				$url = $url . "&manufacturer=" . $this->input->get('manufacturer', true);
			}
			
		}
		
		if(isset($_GET['brand']))
		{
			if($this->input->get('brand', true) != "" && $this->input->get('brand', true) != "all")
			{
				$url = $url . "&brand=" . $this->input->get('brand', true);
			}
			
		}
		
		if(isset($_GET['sort']))
		{
			if($this->input->get('sort', true) != "" )
			{
				$url = $url . "&sort=" . $this->input->get('sort', true);
			}
			
		}
		
		//echo $url;
		$this->TPL['base_search'] = $url;
	}
	
	private function get_provinces()
	{
		$this->db->distinct();
		$this->db->select('province');
		$this->db->from('ADS');
		$this->db->join('USERS', 'ADS.user_id = USERS.id');
		$this->db->join('CATEGORIES', 'ADS.category_id = CATEGORIES.category_id');
		if(isset($_GET['search_string']))
		{
			$this->db->like('ad_title', $this->input->get('search_string', true));
		}
			
		if(isset($_GET['condition']))
		{
			if($this->input->get('condition', true) != "")
			{
				$this->db->where('item_condition', $this->input->get('condition', true));
			}
		}
			
		if(isset($_GET['category']))
		{
			if($this->input->get('category', true) != "all")
			{
				$this->db->where('category_name', $this->input->get('category', true));
			}
		}
		
		if(isset($_GET['city']))
		{
			if($this->input->get('city', true) != "" && $this->input->get('city', true) != "all")
			{
				$url = $url . "&city=" . $this->input->get('city', true);
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
			
		$this->db->order_by('province ASC');
			
		$this->db->where('public', 1);
		$this->db->where('reported', 0);
		$this->db->where('sold', 0);
			
		$query = $this->db->get();
			
		if($query)
		{
			$results = $query->result_array();
				
			$this->TPL['provinces'] = $results;
		}
	}
	
	private function get_cities()
	{
		$this->db->distinct();
		$this->db->select('city');
		$this->db->from('ADS');
		$this->db->join('USERS', 'ADS.user_id = USERS.id');
		$this->db->join('CATEGORIES', 'ADS.category_id = CATEGORIES.category_id');
		if(isset($_GET['search_string']))
		{
			$this->db->like('ad_title', $this->input->get('search_string', true));
		}
			
		if(isset($_GET['category']))
		{
			if(strtolower($this->input->get('category', true) != "all"))
			{
				$this->db->where('category_name', $this->input->get('category', true));
			}
		}
		
		if(isset($_GET['condition']))
		{
			if($this->input->get('condition', true) != "")
			{
				$this->db->where('item_condition', $this->input->get('condition', true));
			}
		}
		
		if(isset($_GET['province']))
		{
			if($this->input->get('province', true) != "" && strtolower($this->input->get('province', true) != "all"))
			{
				$url = $url . "&province=" . $this->input->get('province', true);
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
			
		$this->db->order_by('city ASC');
			
		$this->db->where('public', 1);
		$this->db->where('reported', 0);
		$this->db->where('sold', 0);
			
		$query = $this->db->get();
			
		if($query)
		{
			$results = $query->result_array();
				
			$this->TPL['cities'] = $results;
		}
	}
	
	private function get_condition()
	{
		$this->db->distinct();
		$this->db->select('item_condition');
		$this->db->from('ADS');
		$this->db->join('USERS', 'ADS.user_id = USERS.id');
		$this->db->join('CATEGORIES', 'ADS.category_id = CATEGORIES.category_id');
		if(isset($_GET['search_string']))
		{
			$this->db->like('ad_title', $this->input->get('search_string', true));
		}
			
		if(isset($_GET['category']))
		{
			if($this->input->get('category', true) != "all")
			{
				$this->db->where('category_name', $this->input->get('category', true));
			}
		}
		
		if(isset($_GET['province']))
		{
			if($this->input->get('province', true) != "" && $this->input->get('province', true) != "all")
			{
				$url = $url . "&province=" . $this->input->get('province', true);
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
			
		$this->db->order_by('item_condition ASC');
			
		$this->db->where('public', 1);
		$this->db->where('reported', 0);
		$this->db->where('sold', 0);
			
		$query = $this->db->get();
			
		if($query)
		{
			$results = $query->result_array();
				
			$this->TPL['conditions'] = $results;
		}
	}
	
	private function get_categories()
	{
		$this->db->distinct();
		$this->db->select('category_name');
		$this->db->from('ADS');
		$this->db->join('CATEGORIES', 'ADS.category_id = CATEGORIES.category_id');
		
		if(isset($_GET['search_string']))
		{
			$this->db->like('ad_title', $this->input->get('search_string', true));
		}
		
		if(isset($_GET['province']))
		{
			if($this->input->get('province', true) != "" && $this->input->get('province', true) != "all")
			{
				$url = $url . "&province=" . $this->input->get('province', true);
			}
			
		}
		
		if(isset($_GET['city']))
		{
			if($this->input->get('city', true) != "" && $this->input->get('city', true) != "all")
			{
				$url = $url . "&city=" . $this->input->get('city', true);
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
			
		$this->db->order_by('category_name ASC');
			
		$this->db->where('public', 1);
		$this->db->where('reported', 0);
		$this->db->where('sold', 0);
			
		$query = $this->db->get();
			
		if($query)
		{
			$results = $query->result_array();
				
			$this->TPL['categories'] = $results;
		}
	}
	
	public function get_cities_json()
	{
		$results;
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$province = $this->input->get('province', true);
			$query = $this->db->query("SELECT DISTINCT `city` FROM `USERS` WHERE LOWER(`province`) LIKE '%$province%' ORDER BY `city` DESC;");
			
			if($query)
			{
				$results = $query->result_array();
				
				
				echo json_encode($results);
			}
		}
	}
	
	public function get_brands_json()
	{
		$results;
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$manufacturer = $this->input->get('manufacturer', true);
			$query = $this->db->query("SELECT DISTINCT `BRANDS`.`brand_id`, `brand_name` FROM `BRANDS` JOIN `ADS` ON `BRANDS`.`brand_id` = `ADS`.`brand_id` WHERE `BRANDS`.`manufacturer_id`= $manufacturer ORDER BY `brand_name` DESC;");
			
			if($query)
			{
				$results = $query->result_array();
				
				
				echo json_encode($results);
			}
		}
	}
	
}