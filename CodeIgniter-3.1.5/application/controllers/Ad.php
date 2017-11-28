<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Ad extends CI_Controller
{	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Ad";
		$this->TPL['loggedIn'] = $this->user_auth->validSessionExists();
		

	}
	
	public function index()
	{
		$this->get_ad($this->input->get('ad', true));
		
		echo "<pre>";
		print_r($this->TPL);
		print_r($_SESSION);
		echo "</pre>";
		
		$this->template->show("ad",$this->TPL);
	}

	
	private function get_ad($id)
	{
		$this->db->select('ADS.ad_id, item_description, ad_title, item_condition, item_price, post_date, user_name, brand_name, image_location, city, province, category_name, USERS.user_name');
		$this->db->from('ADS');
		$this->db->join('USERS', 'ADS.user_id = USERS.id');
		$this->db->join('BRANDS', 'ADS.brand_id = BRANDS.brand_id');
		$this->db->join('MANUFACTURERS', 'BRANDS.manufacturer_id = MANUFACTURERS.manufacturer_id');
		$this->db->join('IMAGES', 'ADS.ad_id = IMAGES.ad_id');
		$this->db->join('CATEGORIES', 'ADS.category_id = CATEGORIES.category_id');
		$this->db->where('ADS.ad_id', $this->input->get('ad', true));
		$this->db->where('public', 1);
		$this->db->where('reported', 0);
		$this->db->where('sold', 0);
		
		$query = $this->db->get();
		
		if($query)
		{
			$this->TPL['details'] = $query->row_array();
		}
		
	}
	
}