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
			$date = date("Y/m/d h:i:s");
			if($this->input->post('visibility', true) != "true")
			{
				$public = false;
			}
			
			$ad_data = [
				'user_id' => $_SESSION['user_id'],
				//'brand_id => $this->input->post('brand, true),
				'brand_id' => 1,
				//'category' => $this->input->post('category', true),
				'category' => 1,
				'title' => $this->input->post('title', true),
				//'condition' => $this->input->post('condition', true),
				'condition' => "Mostly played",
				'price' => $this->input->post('price', true),
				'description' => $this->input->post('description', true),
				'post_date' => $date,
				'bump_date' => $date,
				'visibility' => $public
			];
			
			echo "<pre>";
			print_r($ad_data);
			echo "</pre>";
			
			echo $public;
			
			$sql = "INSERT INTO `ADS`(`user_id`, `brand_id`, `category_id`, `ad_title`, `item_condition`, `item_price`, `item_description`, `post_date`, `bump_date`, `public`)
					VALUES(?,?,?,?,?,?,?,?,?,?);";
			$query = $this->db->query($sql, $ad_data);
			if($query)
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