<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostAnAd extends CI_Controller {
	
	
	var $TPL;
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Post an ad";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		
	}

	public function index()
	{
		if($this->TPL['loggedIn'])
		{
			$this->template->show('post_an_ad', $this->TPL);
			
		}
		else
		{
			redirect("c=login");
		}
		
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
				$this->db->select('ad_id');
				$this->db->from('ADS');
				$this->db->where('user_id', $_SESSION['user_id']);
				$this->db->where('post_date', $date);
				$query = $this->db->get();
				if($query){
					$details = $query->result_array();
					
					$ad_id = $details[0]['ad_id'];
					
					if($this->upload($ad_id))
					{
						$this->user_auth->redirect(base_url() . "index.php?c=Ad&ad=$ad_id");
					}
					else
					{
						$this->user_auth->redirect(base_url() . "index.php?c=PostAnAd");
					}
					
				}
			}
			else
			{
				echo "An error has occured";
			}
		}
		else
		{
			$this->user_auth->redirect(base_url() . "index.php?c=PostAnAd");
		}
	}
	
	private function upload($ad_id)
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpeg|png|jpg';
		$config['max_size'] = '2048';
		$config['max_width'] = '2000';
		$config['max_height'] = '2000';
		
		$this->load->library('upload', $config);
		
		if( ! $this->upload->do_upload('image'))
		{
			echo "<pre>";
			print_r($this->upload->display_errors());
			var_dump($_FILES);
			echo "</pre>";
			return false;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file_location = $this->upload->data('file_name');
			$this->db->insert('IMAGES', array('owner_id' => $_SESSION['user_id'], 'image_location' => $file_location, 'ad_id' => $ad_id));
			return true;
		}
	}
	
}