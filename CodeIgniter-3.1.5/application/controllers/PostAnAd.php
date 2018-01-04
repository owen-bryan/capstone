<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostAnAd extends CI_Controller {
	
	
	var $TPL;
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Post an ad";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		$this->TPL['admin'] = $this->ion_auth->is_admin();
		
		if($this->TPL['loggedIn'] == false)
		{
			$this->TPL['error'] = true;
			$this->TPL['error_msg'] = "You must be logged in to access this page";
			
			$this->TPL['page'] = "Log in";
			
			$this->template->show("login", $this->TPL);
		}
		else
		{
			//$this->TPL['ascess_level'] = $this->ion_auth->user()-row()-
		}
	}

	public function index()
	{
		
		$this->get_data();
		$this->template->show('post_an_ad', $this->TPL);
		
		
	}
	
	private function get_data()
	{
		$query = $this->db->query("SELECT * FROM CATEGORIES;");
		
		if($query)
		{
			$i = 0;
			foreach($query->result_array() as $row)
			{
				$this->TPL['categories'][$i]['id'] = $row['category_id'];
				$this->TPL['categories'][$i]['name'] = $row['category_name'];
				$i++;
			}
		}
		
		$query = $this->db->query("SELECT DISTINCT `province` FROM `USERS` WHERE `banned`= 0");
		
		if($query)
		{
			$i = 0;
			foreach($query->result_array() as $row)
			{
				$this->TPL['provinces'][$i] = $row['province'];
				$i++;
			}
		}
		
		$query = $this->db->query("SELECT `manufacturer_id`, `manufacturer_name` FROM `MANUFACTURERS`");
		
		if($query)
		{
			$i = 0;
			foreach($query->result_array() as $row)
			{
				$this->TPL['manufacturers'][$i]['name'] = $row['manufacturer_name'];
				$this->TPL['manufacturers'][$i]['id'] = $row['manufacturer_id'];
				$i++;
			}
		}
		
		// echo "<pre>";
		// print_r($this->TPL);
		// echo "</pre>";
		
	}

	public function new_ad()
	{
		if($_SERVER['REQUEST_METHOD'] == "POST")
		{
			$this->form_validation->set_rules('title', 'Ad Title', 'trim|required');
			$this->form_validation->set_rules('price', 'Ad Price', 'trim|required|numeric|callback_validate_price');
			$this->form_validation->set_rules('description', 'Ad Price', 'trim');
			$this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
			if($this->form_validation->run() == true)
			{
				$public = true;
				$date = date("Y-m-d H:i:s");
				$user =  $this->ion_auth->user()->row();
				$user_id = $user->id;
				if($this->input->post('visibility', true) != "true")
				{
					$public = false;
				}
				
				$ad_data = [
					'user_id' => $user_id,
					'ad_title' => $this->input->post('title', true),
					'item_condition' => $this->input->post('condition', true),
					'item_price' => $this->input->post('price', true),
					'post_date' => $date,
					'bump_date' => $date,
					'public' => $public
				];
	
				if(trim($this->input->post("brand", true))  != "")
				{
					$ad_data['brand_id'] = $this->input->post('brand', true);
				}
				if(trim($this->input->post("category")) != "")
				{
					$ad_data['category_id'] = $this->input->post('category', true);
				}
				if(trim($this->input->post("description")) != "")
				{
					$ad_data['item_description'] = $this->input->post('description', true);
				}
				
				echo "<pre>";
				print_r($ad_data);
				//print_r($this->TPL);
				echo "</pre>";
				
				
				
				if($this->db->insert('ADS', $ad_data))
				{
					$this->db->select('ad_id');
					$this->db->from('ADS');
					$this->db->where('user_id', $user_id);
					$this->db->where('post_date', $date);
					$query = $this->db->get();
					if($query){
						$details = $query->result_array();
						
						$ad_id = $details[0]['ad_id'];
						
						if(trim($this->input->post("image",true)))
						{
							if($this->upload($ad_id))
							{
								redirect("index.php?c=Ad&ad=$ad_id");
							}
							else
							{
								$this->get_data();
								$this->TPL['error'] = true;
								$this->TPL['error_msg'] = "Unknown Database error occurred please try again later";
								$this->template->show("post_an_ad", $this->TPL);
							}	
						}
						else
						{
							redirect("c=Ad&ad=$ad_id");
						}
						
						
					}else
						{
							$this->get_data();
							$this->TPL['error'] = true;
							$this->TPL['error_msg'] = "Unknown Database error occurred please try again later";
							$this->template->show("post_an_ad", $this->TPL);
						}
				}
				else
				{
					$this->get_data();
					$this->TPL['error'] = true;
					$this->TPL['error_msg'] = "Error image failed to upload. Please ensure the image is less than 10mb and resolution is less than 5000 x 5000 px.";
					$this->template->show("post_an_ad", $this->TPL);
				}
			}
			else
			{
				$this->get_data();
				$this->TPL['error'] = true;
				$this->template->show("post_an_ad", $this->TPL);
			}
		}
		else
		{
			$this->user_auth->redirect(base_url() . "index.php?c=PostAnAd");
		}
	}
	
	public function validate_price($price)
	{
		
		if($price > 0)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('validate_price', 'The Ad Price must be greater than 0.');
			return false;
		}
	}
	
	private function upload($ad_id)
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpeg|png|jpg';
		$config['max_size'] = '10000';
		$config['max_width'] = '5000';
		$config['max_height'] = '5000';
		
		$this->load->library('upload', $config);
		
		if(trim($this->input->post('image', true)) != "")
		{
			if( ! $this->upload->do_upload('image'))
			{
				/* echo "<pre>";
				print_r($this->upload->display_errors());
				var_dump($_FILES);
				echo "</pre>"; */
				return false;
			}
			else
			{
				$data = array('upload_data' => $this->upload->data());
				$file_location = $this->upload->data('file_name');
				$this->db->insert('IMAGES', array('owner_id' => $this->ion_auth->users()-row()->id, 'image_location' => $file_location, 'ad_id' => $ad_id));
				return true;
			}
		}
		else
		{
			$this->db->insert('IMAGES', array('owner_id' => $$this->ion_auth->users()-row()->id, 'image_location' => "", 'ad_id' => $ad_id));
			return true;
		}
		
	}
	
}