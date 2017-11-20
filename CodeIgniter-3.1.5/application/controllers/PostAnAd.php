<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostAnAd extends CI_Controller {
	
	
	var $TPL;
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Post an ad";
		$this->TPL['loggedin'] = $this->user_auth->loggedin(base_url() . "index.php?/PostAnAd");
		
	}

	public function index()
	{
		$this->template->show('post_an_ad', $this->TPL);
	}

	public function new_ad()
	{
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$public = true;
			date_default_timezone_set("UTC");
			$date = date("Y-m-d H:i:s");
			if($this->input->post('visibility', true) != "true")
			{
				$public = false;
			}
			
			$ad_data = [
				'user_id' => $_SESSION['user_id'],
				//'brand_id => $this->input->post('brand, true),
				'brand_id' => 1,
				//'category' => $this->input->post('category', true),
				'category_id' => 1,
				'ad_title' => $this->input->post('title', true),
				//'condition' => $this->input->post('condition', true),
				'item_condition' => "Mostly played",
				'item_price' => $this->input->post('price', true),
				'item_description' => $this->input->post('description', true),
				'post_date' => $date,
				'bump_date' => $date,
				'public' => $public
			];
			
			
			
			
			echo "<pre>";
			print_r($ad_data);
			echo "</pre>";
			
			
			if($this->db->insert('ADS', $ad_data))
			{
				echo "SUCCESS";
			}
			else
			{
				echo "An error has occured";
			}
		}
		else
		{
			$this->user_auth->redirect(base_url() . "index.php?/PostAnAd");
		}
	}
	
}