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
		$this->TPL['username'] = $this->ion_auth->user()->row()->user_name;
		if($this->TPL['loggedIn'] == false)
		{
			$this->TPL['error'] = true;
			$this->TPL['error_msg'] = "You must be logged in to access this page";
			
			$this->TPL['page'] = "Log in";
			
			$this->template->show("login", $this->TPL);
		}
	}

	public function index()
	{
		
		$this->get_data();
		$this->template->show('post_an_ad', $this->TPL);
		
		
	}
	
	private function get_data()
	{
		$query = $this->db->query("SELECT * FROM CATEGORIES ORDER BY `category_name` ASC;");
		
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
		
		$query = $this->db->query("SELECT DISTINCT `province` FROM `USERS` WHERE `banned`= 0 ORDER BY `province` ASC");
		
		if($query)
		{
			$i = 0;
			foreach($query->result_array() as $row)
			{
				$this->TPL['provinces'][$i] = $row['province'];
				$i++;
			}
		}
		
		$query = $this->db->query("SELECT `manufacturer_id`, `manufacturer_name` FROM `MANUFACTURERS` ORDER BY `manufacturer_name` ASC ");
		
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
			$this->form_validation->set_rules('price', 'Ad Price', 'trim|required|numeric|callback__validate_price');
			$this->form_validation->set_rules('description', 'Description', 'trim');
			$this->form_validation->set_rules('condition', 'Condition', 'trim|callback__validate_condition');
			$this->form_validation->set_rules('brand', 'Condition', 'trim|callback__validate_brand');
			$this->form_validation->set_rules('manufacturer', 'Condition', 'trim|callback__validate_manufacturer');
			if(is_uploaded_file($_FILES['image']['name']) )
			{
				$this->form_validation->set_rules('image', 'Image', "callback__upload_validation");	
			}
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
	
				if(trim($this->input->post("manufacturer", true))  != "")
				{
					$query = $this->db->select('manufacturer_id')->from('MANUFACTURERS')->where('manufacturer_name',$this->input->post('manufacturer', true));
					$result = $this->db->get();
					$manufacturer =  $result->row();
					$ad_data['manufacturer_id'] = $manufacturer->manufacturer_id;
				}
				if(trim($this->input->post("brand", true))  != "" && trim($this->input->post("manufacturer", true))  != "")
				{
					$query = $this->db->select('brand_id')->from('BRANDS')->like('brand_name',$this->input->post('brand', true))->where('manufacturer_id',$ad_data['manufacturer_id']);
					$result = $this->db->get();
					$brand = $result->row();
					$ad_data['brand_id'] = $brand->brand_id;
				}
				if(trim($this->input->post("category")) != "")
				{
					$ad_data['category_id'] = $this->input->post('category', true);
				}
				if(trim($this->input->post("description")) != "")
				{
					$ad_data['item_description'] = $this->input->post('description', true);
				}
				
				
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
					
						if(is_uploaded_file($_FILES['image']['name']) )
						{
							$this->db->insert('IMAGES', array('owner_id' => $this->ion_auth->users()->row()->id, 'image_location' => $this->TPL['image_location'], 'ad_id' => $ad_id));
						}
						//redirect("c=Ad&ad=$ad_id");
						echo "<pre>";
						print_r($_FILES);
						echo "</pre>";
						
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
	
	public function _validate_condition($str)
	{
		if($str == "Lightly played" || $str == "Near mint" || $str == "Moderately played" || $str == "Heavily played" || $str == "Damaged")
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('_validate_condition', 'Please choose a valid condition.');
			return false;
		}
	} 
	
	public function _validate_manufacturer($str)
	{
		$exists = $this->db->like('manufacturer_name', $str)
						->limit(1)
						->from("MANUFACTURERS")
						->count_all_results() > 0;
		if($exists)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('_validate_manufacturer', 'Please choose a valid manufacturer.');
			return false;
		}
	}

	public function _validate_brand($str)
	{
		$exists = $this->db->like('brand_name', $str)
						->limit(1)
						->from("BRANDS")
						->count_all_results() > 0;
		if($exists)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('_validate_brand', 'Please choose a valid brand.');
			return false;
		}
	} 
	
	public function _validate_price($price)
	{
		
		if($price > 0)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('_validate_price', 'The Ad Price must be greater than 0.');
			return false;
		}
	}
	public function _validate_category($str)
	{
		$exists = $this->db->like('category_name', $str)
						->limit(1)
						->from("CATEGORIES")
						->count_all_results() > 0;
		
		if($price > $exists)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('_validate_category', 'Please choose a valid category.');
			return false;
		}
	}
	
	public function _upload_validation()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpeg|png|jpg';
		$config['max_size'] = '10240';
		$config['max_width'] = '5000';
		$config['max_height'] = '5000';
		
		$this->load->library('upload', $config);
		
		if( ! $this->upload->do_upload('image'))
		{
			$this->form_validation->set_message("_upload_validation", "Image Failed to upload. Please make sure it is of file size 10mb or less, and is of file type jpeg, gif, or png file.");
			return false;
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
			$file_location = $this->upload->data('file_name');
			$this->TPL['image_location'] = $file_location;
			echo $file_location;
			return true;
		}
	}
		
	
	
}