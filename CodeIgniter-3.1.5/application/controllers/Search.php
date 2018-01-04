<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Search";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		$this->TPL['admin'] = $this->ion_auth->is_admin();
		
		if(isset($_GET['search_string']))
		{
			$this->TPL['search_string'] =  urldecode($this->input->get("search_string", true));
		}
		
		if(isset($_GET['category']))
		{
			$this->TPL['current_category'] = urldecode($this->input->get("category", true));
		}

		if(isset($_GET['condition']))
		{
			$this->TPL['current_condition'] = urldecode($this->input->get("condition", true));
		}
		
		if(isset($_GET['manufacturer']))
		{
			$this->TPL['current_manufacturer'] = urldecode($this->input->get("manufacturer", true));
		}
		
		if(isset($_GET['brand']))
		{
			$this->TPL['current_brand'] = urldecode($this->input->get("brand", true));
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
			$this->TPL['current_province'] =  urldecode($this->input->get("province", true));
		}
		if(isset($_GET['city']))
		{
			$this->TPL['current_city'] =  urldecode($this->input->get("city", true));
		}
	}
	
	public function index()
	{
		$this->display();
	}
	
	public function display()
	{	
		if($_SERVER['REQUEST_METHOD'] = "GET")
		{
			
			$this->db->select('ADS.ad_id, item_description, ad_title, item_condition, item_price, post_date, user_name, brand_name, image_location, city, province, category_name, USERS.user_name');
			$this->db->from('ADS');
			$this->db->join('USERS', 'ADS.user_id = USERS.id');
			$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id', "left");
			$this->db->join('MANUFACTURERS', 'BRANDS.manufacturer_id = MANUFACTURERS.manufacturer_id');
			$this->db->join('IMAGES', 'ADS.ad_id = IMAGES.ad_id');
			$this->db->join('CATEGORIES', 'ADS.category_id = CATEGORIES.category_id');
			
			if(isset($_GET['search_string']))
			{
				$this->db->like('ad_title', $this->TPL['search_string']);
			}
			
			if(isset($_GET['category']))
			{
				if(trim($this->input->get('category', true) != ""))
				{
					$this->db->where('category_name', $this->TPL['current_category']);
				}
			}
			
			if(isset($_GET['province']))
			{
				if(trim($this->input->get("province", true) != ""))
				{
					$this->db->where('province', $this->TPL['current_province']);
				}
			}
			
			if(isset($_GET['city']))
			{
				if(trim($this->input->get("city", true) != ""))
				{
					$this->db->where('city', $this->TPL['current_city']);
				}
			}
			
			if(isset($_GET['condition']))
			{
				if(trim($this->input->get('condition', true) != ""))
				{
					$this->db->where('item_condition', $this->TPL['current_condition']);
				}
			}
			
			if(isset($_GET['low_price']))
			{
				if(trim($this->input->get('low_price', true) != ""))
				{
					$this->db->where('item_price >=', $this->TPL['low_price']);
				}
			}
			

			if(isset($_GET['high_price']))
			{
				if(trim($this->input->get('high_price', true)) != "")
				{
					$this->db->where('item_price <=', $this->TPL['high_price']);
				}
			}
			
			if(isset($_GET['manufacturer']))
			{
				if(trim($this->input->get('manufacturer', true)) != "" && trim($this->input->get('manufacturer', true) != ""))
				{
					$this->db->like('manufacturer_name', $this->TPL['current_manufacturer']);
				}
			}
			
			if(isset($_GET['brand']))
			{
				$this->db->where('brand_name', $this->TPL['current_brand']);
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
					if(!$this->input->get("category",true) || trim($this->TPL['current_category']) == "")
					{
						$this->get_categories();
					}
					if(!$this->input->get("condition",true))
					{
						$this->get_condition();
					}
					if(!$this->input->get("manufacturer",true) || trim($this->TPL['current_current_manufacturer']) == "")
					{
						$this->get_manufacturers();
					}
					if($this->input->get("manufacturer",true) || trim($this->TPL['current_brand']) == "")
					{
						$this->get_brands();
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
			if(trim($this->input->get('search_string', true)) != "")
			{	
				$url = $url . "&search_string=" . $this->input->get('search_string', true);
			}
		}
		
		if(isset($_GET['category']))
		{
			if(trim($this->input->get('category', true)) != "" && $this->input->get('category', true) != "")
			{
				$url = $url . "&category=" . $this->input->get('category', true);
			}
			
		}if(isset($_GET['condition']))
		{
			if(trim($this->input->get('condition', true)) != "" && $this->input->get('condition', true) != "")
			{
				$url = $url . "&condition=" . $this->input->get('condition', true);
			}
		}
		
		if(isset($_GET['low_price']))
		{
			if(trim($this->input->get('low_price', true)) != ""  && is_numeric($this->input->get('low_price', true)) == true)
			{
				$url = $url . "&low_price=" . $this->input->get('low_price', true);
			}
		}
		
		if(isset($_GET['high_price']))
		{
			if(trim($this->input->get('high_price', true)) != "" && is_numeric($this->input->get('high_price', true)) == true)
			{
				$url = $url . "&high_price=" . $this->input->get('high_price', true);
			}
		}
		
		if(isset($_GET['province']))
		{
			if(trim($this->input->get('province', true)) != "")
			{
				$url = $url . "&province=" . $this->input->get('province', true);
			}
			
		}
		
		if(isset($_GET['city']))
		{
			if(trim($this->input->get('city', true)) != "" )
			{
				$url = $url . "&city=" . $this->input->get('city', true);
			}
			
		}
		
		if(isset($_GET['manufacturer']))
		{
			if(trim($this->input->get('manufacturer', true)) != "" )
			{
				$url = $url . "&manufacturer=" . $this->input->get('manufacturer', true);
			}
			
		}
		
		if(isset($_GET['brand']))
		{
			if(trim($this->input->get('brand', true)) != "")
			{
				$url = $url . "&brand=" . $this->input->get('brand', true);
			}
			
		}
		
		if(isset($_GET['sort']))
		{
			if(trim($this->input->get('sort', true)) != "" )
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
		$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id');
		$this->db->join('MANUFACTURERS', 'BRANDS.manufacturer_id = MANUFACTURERS.manufacturer_id');
		
		if(isset($_GET['search_string']))
		{
			$this->db->like('ad_title', $this->input->get('search_string', true));
		}
			
		if(isset($_GET['condition']))
		{
			if(trim($this->input->get('condition', true)) != "")
			{
				$this->db->where('item_condition', $this->input->get('condition', true));
			}
		}
			
		if(isset($_GET['category']))
		{
			if(trim($this->input->get('category', true)) != "")
			{
				$this->db->where('category_name', $this->input->get('category', true));
			}
		}
		
		if(isset($_GET['city']))
		{
			if(trim($this->input->get('city', true)) != "")
			{
				$this->db->where('city', $this->input->get('city', true));
			}
			
		}
		
		if(isset($_GET['low_price']))
		{
			if(trim($this->input->get('low_price', true)) != "")
			{
				$this->db->where('item_price >=', $this->input->get('low_price', true));
			}
		}
			
		if(isset($_GET['high_price']))
		{
			if(trim($this->input->get('high_price', true)) != "")
			{
				$this->db->where('item_price <=', $this->input->get('high_price', true));
			}
		}
		
		if(isset($_GET['manufacturer']))
		{
			if(trim($this->input->get('manufacturer', true)) != "" )
			{
				$this->db->where('manufacturer_name', $this->input->get('manufacturer', true));
			}
			
		}
			
		if(isset($_GET['brand']))
		{
			$this->db->where('brand_name', $this->input->get('brand', true));
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
		$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id');
		$this->db->join('MANUFACTURERS', 'BRANDS.manufacturer_id = MANUFACTURERS.manufacturer_id');
		
		if(isset($_GET['search_string']))
		{
			$this->db->like('ad_title', $this->input->get('search_string', true));
		}
			
		if(isset($_GET['category']))
		{
			if(trim($this->input->get('category', true)) != "")
			{
				$this->db->where('category_name', $this->input->get('category', true));
			}
		}
		
		if(isset($_GET['condition']))
		{
			if(trim($this->input->get('condition', true)) != "")
			{
				$this->db->where('item_condition', $this->input->get('condition', true));
			}
		}
		
		if(isset($_GET['province']))
		{
			if(trim($this->input->get('province', true)) != "" )
			{
				$this->db->where('province', $this->input->get('province', true));
			}
			
		}
		
		if(isset($_GET['low_price']))
		{
			if(trim($this->input->get('low_price', true)) != "")
			{
				$this->db->where('item_price >=', $this->input->get('low_price', true));
			}
		}
			
		if(isset($_GET['high_price']))
		{
			if(trim($this->input->get('high_price', true)) != "")
			{
				$this->db->where('item_price <=', $this->input->get('high_price', true));
			}
		}
		
		if(isset($_GET['manufacturer']))
		{
			if(trim($this->input->get('manufacturer', true)) != "" )
			{
				$this->db->where('manufacturer_name', $this->input->get('manufacturer', true));
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
		$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id');
		$this->db->join('MANUFACTURERS', 'BRANDS.manufacturer_id = MANUFACTURERS.manufacturer_id');
		
		
		if(isset($_GET['search_string']))
		{
			$this->db->like('ad_title', $this->input->get('search_string', true));
		}
			
		if(isset($_GET['category']))
		{
			if(trim($this->input->get('category', true)) != "")
			{
				$this->db->where('category_name', $this->input->get('category', true));
			}
		}
		
		if(isset($_GET['province']))
		{
			if(trim($this->input->get('province', true)) != "" )
			{
				$this->db->where('province', $this->input->get('province', true));
			}
			
		}
		
		if(isset($_GET['manufacturer']))
		{
			if(trim($this->input->get('manufacturer', true)) != "")
			{
				$this->db->where('manufacturer_name', $this->input->get('manufacturer', true));
			}
			
		}
		
		if(isset($_GET['city']))
		{
			if(trim($this->input->get('city', true)) != "" && trim($this->input->get('city', true)) != "")
			{
				$this->db->where('city', $this->input->get('city', true));
			}
			
		}
		
		if(isset($_GET['low_price']))
		{
			if(trim($this->input->get('low_price', true)) != "")
			{
				$this->db->where('item_price >=', $this->input->get('low_price', true));
			}
		}
			
		if(isset($_GET['high_price']))
		{
			if(trim($this->input->get('high_price', true)) != "")
			{
				$this->db->where('item_price <=', $this->input->get('high_price', true));
			}
		}
		
		
		if(isset($_GET['condition']))
		{
			if(trim($this->input->get('condition', true)) != "")
			{
				$this->db->where('item_condition', $this->input->get('condition', true));
			}
		}
		
		
			
		if(isset($_GET['brand']))
		{
			$this->db->where('brand_name', $this->input->get('brand', true));
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
		$this->db->join('USERS', 'ADS.user_id = USERS.id');
		$this->db->join('CATEGORIES', 'ADS.category_id = CATEGORIES.category_id');
		$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id');
		$this->db->join('MANUFACTURERS', 'BRANDS.manufacturer_id = MANUFACTURERS.manufacturer_id');
		
		if(isset($_GET['search_string']))
		{
			$this->db->like('ad_title', $this->input->get('search_string', true));
		}
		
		if(isset($_GET['province']))
		{
			if(trim($this->input->get('province', true)) != "")
			{
				$this->db->where('province', $this->input->get('province', true));
			}
			
		}
		
		if(isset($_GET['city']))
		{
			if(trim($this->input->get('city', true)) != "")
			{
				$this->db->where('city', $this->input->get('city', true));
			}
			
		}
		
		if(isset($_GET['low_price']))
		{
			if(trim($this->input->get('low_price', true)) != "")
			{
				$this->db->where('item_price >=', $this->input->get('low_price', true));
			}
		}
			
		if(isset($_GET['high_price']))
		{
			if(trim($this->input->get('high_price', true)) != "")
			{
				$this->db->where('item_price <=', $this->input->get('high_price', true));
			}
		}
			
		
		if(isset($_GET['condition']))
		{
			if(trim($this->input->get('condition', true)) != "")
			{
				$this->db->where('item_condition', $this->input->get('condition', true));
			}
		}
			
		if(isset($_GET['manufacturer']))
		{
			if(trim($this->input->get('manufacturer', true)) != "" )
			{
				$this->db->where('manufacturer_name', $this->input->get('manufacturer', true));
			}
			
		}
			
		if(isset($_GET['brand']))
		{
			$this->db->where('brand_name', $this->input->get('brand', true));
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
	
	private function get_manufacturers()
	{
		$this->db->distinct();
		$this->db->select('manufacturer_name');
		$this->db->from('ADS');
		$this->db->join('USERS', 'ADS.user_id = USERS.id');
		$this->db->join('CATEGORIES', 'ADS.category_id = CATEGORIES.category_id');
		$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id');
		$this->db->join('MANUFACTURERS', 'BRANDS.manufacturer_id = MANUFACTURERS.manufacturer_id');
		
		if(isset($_GET['search_string']))
		{
			$this->db->like('ad_title', $this->input->get('search_string', true));
		}
		
		if(isset($_GET['province']))
		{
			if(trim($this->input->get('province', true)) != "" )
			{
				$this->db->where('province', $this->input->get('province', true));
			}
			
		}
		
		if(isset($_GET['city']))
		{
			if(trim($this->input->get('city', true)) != "" )
			{
				$this->db->where('city', $this->input->get('city', true));
			}
			
		}
		
		if(isset($_GET['low_price']))
		{
			if(trim($this->input->get('low_price', true)) != "")
			{
				$this->db->where('item_price >=', $this->input->get('low_price', true));
			}
		}
			
		if(isset($_GET['high_price']))
		{
			if(trim($this->input->get('high_price', true)) != "")
			{
				$this->db->where('item_price <=', $this->input->get('high_price', true));
			}
		}
			
		
		if(isset($_GET['condition']))
		{
			if(trim($this->input->get('condition', true)) != "")
			{
				$this->db->where('item_condition', $this->input->get('condition', true));
			}
		}
			
		if(isset($_GET['brand']))
		{
			$this->db->where('brand_name', $this->input->get('brand', true));
		}
			
		$this->db->order_by('manufacturer_name ASC');
			
		$this->db->where('public', 1);
		$this->db->where('reported', 0);
		$this->db->where('sold', 0);
			
		$query = $this->db->get();
			
		if($query)
		{
			$results = $query->result_array();
				
			$this->TPL['manufacturers'] = $results;
		}
	}
	
	private function get_brands()
	{
		$this->db->distinct();
		$this->db->select('brand_name');
		$this->db->from('ADS');
		$this->db->join('USERS', 'ADS.user_id = USERS.id');
		$this->db->join('CATEGORIES', 'ADS.category_id = CATEGORIES.category_id');
		$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id');
		$this->db->join('MANUFACTURERS', 'BRANDS.manufacturer_id = MANUFACTURERS.manufacturer_id');
		
		if(isset($_GET['search_string']))
		{
			$this->db->like('ad_title', $this->input->get('search_string', true));
		}
		
		if(isset($_GET['province']))
		{
			if(trim($this->input->get('province', true)) != "" )
			{
				$this->db->where('province', $this->input->get('province', true));
			}
			
		}
		
		if(isset($_GET['city']))
		{
			if(trim($this->input->get('city', true)) != "" )
			{
				$this->db->where('city', $this->input->get('city', true));
			}
			
		}
		
		if(isset($_GET['low_price']))
		{
			if(trim($this->input->get('low_price', true)) != "")
			{
				$this->db->where('item_price >=', $this->input->get('low_price', true));
			}
		}
			
		if(isset($_GET['high_price']))
		{
			if(trim($this->input->get('high_price', true)) != "")
			{
				$this->db->where('item_price <=', $this->input->get('high_price', true));
			}
		}
			
		
		if(isset($_GET['condition']))
		{
			if(trim($this->input->get('condition', true)) != "")
			{
				$this->db->where('item_condition', $this->input->get('condition', true));
			}
		}
			
		$this->db->order_by('brand_name ASC');
			
		$this->db->where('public', 1);
		$this->db->where('reported', 0);
		$this->db->where('sold', 0);
			
		$query = $this->db->get();
			
		if($query)
		{
			$results = $query->result_array();
				
			$this->TPL['brands'] = $results;
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
			$query = $this->db->query("SELECT DISTINCT `BRANDS`.`brand_id`, `brand_name` FROM `BRANDS` JOIN `ADS` ON `BRANDS`.`brand_id` = `ADS`.`brand_id` WHERE `BRANDS`.`manufacturer_id`= 
			(SELECT `manufacturer_id` FROM `MANUFACTURERS` WHERE `manufacturer_name` LIKE ?) ORDER BY `brand_name` ASC;", $manufacturer);
			
			if($query)
			{
				$results = $query->result_array();
				
				
				echo json_encode($results);
			}
		}
	}
	
}