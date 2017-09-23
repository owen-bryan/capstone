<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Search extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Search";
		$this->TPL['loggedIn'] = false;
		
	}
	
	public function index()
	{
		
		
		$if(isset($_POST)){
			$query = $this->db->query('Select ad_id, user_id, item_description, ad_title, item_condition, item_price, post_date, image_location, user_name from ADS join USERS on ADS.user_id = USERS.user_id join IMAGES on  IMAGES.user_id = ADS.user_id where public = 1, reported = 0, status != \'sold\'');
			foreach($query->result_array as $row)
			{
				$this->TPL['results'][]['title'] = $row['ad_title'];
				$this->TPL['results'][]['condition'] = $row['item_condition'];
				$this->TPL['results'][]['price'] = $row['item_price'];
				$this->TPL['results'][]['desc'] = $row['item_description'];
				$this->TPL['results'][]['date'] = $row['post_date'];
				$this->TPL['results'][]['location'] = $row['item_condition'];
				$this->TPL['results'][]['img'] = $row['item_condition'];
			}
		}
		
		$this->template->show('search', $this->TPL);
	}
	
	
	public 
}