<?php 
defined('BASEPATH') or exit('No direct script access allowed');
/*
	Class by: Owen Bryan, 000340128.
*/
class Edit extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
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
		edit_user();
	}
	
	/*
		Gets the details so the users can know what they are changing on their account and displays the edit user form.
	*/
	public function edit_user()
	{
		$this->TPL['page'] = "Edit account";
		$user = $this->ion_auth->user()->row();
		$this->db->from("USERS")->where("id", $user->id);
		$query = $this->db->get();
		if($query)
		{ 
			
			$results = $query->result_array();
			if($results)
			{
				$this->TPL['user'] = $results;
				
				$this->template->show("edit_user", $this->TPL);
			}
		}
		
	}
	
	/*
		Gets the ad so the users can know what they are changing on their ad and displays the edit ad form.
	*/
	public function edit_ad()
	{
		$this->TPL['page'] = "Edit ad";
		$user = $this->ion_auth->user()->row();
		$ad_id = $this->input->get("ad", true);
		$user_id = $user->id;
		
		
		$this->get_ad($ad_id, $user_id);
		$this->template->show("edit_ad", $this->TPL);
					
	}
	
	/*
		a function to retrieve the ad and ensure this user owns the ad
	*/
	private function get_ad($id,$uid)
	{
		$this->db->select()->from("ADS")->where("ad_id", $id)->where("user_id", $uid);
		$query = $this->db->get();
		if($query)
		{ 
			$results = $query->result_array();
			if($results)
			{
				if($results[0]['user_id'] == $uid)
				{
		
					$this->TPL['ad'] = $results;
					$this->TPL['ad_id'] = $id;
					$this->get_data();
				}
				else
				{
					redirect("c=ad&ad=$id");
				}
			}
			else
			{
				redirect("c=ad&ad=$id");
			}
		}
	}
	/*
		Validates and checks to see what changes were made and then updates the ad in the database.
	*/
	public function edit_ad_submit()
	{
		$this->form_validation->set_rules('title', 'Ad Title', 'trim');
		$this->form_validation->set_rules('description', 'Description', 'trim');
		$this->form_validation->set_rules('brand', 'Condition', 'trim|callback__validate_brand');
		$this->form_validation->set_rules('manufacturer', 'Condition', 'trim|callback__validate_manufacturer');
		
		if($_FILES['image']['name'] != "")
		{
			$this->form_validation->set_rules('image', 'Image', "callback__upload_validation");	
		}
		
		if(trim($this->input->post('price', true)) != "")
		{
			$this->form_validation->set_rules('price', 'Ad Price', 'trim|callback__validate_price|numeric');
		}

		if(trim($this->input->post('condition', true)) != "")
		{
			$this->form_validation->set_rules('condition', 'Condition', 'trim|callback__validate_condition');
		}
		
		$this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
		
		if($this->form_validation->run() == true)
		{
			
			$id = $this->ion_auth->user()->row()->id;
			$data;
			$this->TPL['ad_id'] = $this->input->post("ad",true);
			
			
			if(trim($this->input->post("title", true)) != "")
			{
				$data['ad_title'] = trim($this->input->post("title", true));
			}
			
			if(trim($this->input->post("price", true)) != "")
			{
				$data['item_price'] = trim($this->input->post("price", true));
			}
			
			if(trim($this->input->post("category", true)) != "")
			{
				$data['category_id'] = trim($this->input->post("category", true));
			}
			
			if(trim($this->input->post("condition", true)) != "")
			{
				$data['item_condition'] = trim($this->input->post("condition", true));
			}
			
			if(trim($this->input->post("manufacturer", true)) != "")
			{
				$query = $this->db->select('manufacturer_id')->from('MANUFACTURERS')->where('manufacturer_name',$this->input->post('manufacturer', true));
						$result = $this->db->get();
						$manufacturer =  $result->row();
				$data['manufacturer_id'] = $manufacturer->manufacturer_id;
			}
			
			if(trim($this->input->post("brand", true)) != "" && trim($this->input->post("manufacturer", true)) != "")
			{
				$query = $this->db->select('brand_id')->from('BRANDS')->like('brand_name',$this->input->post('brand', true))->where('manufacturer_id',$data['manufacturer_id']);
						$result = $this->db->get();
						$brand = $result->row();
				$data['brand_id'] = $brand->brand_id;
			/* 	echo "<pre>";
				print_r($query);
				echo "</pre>"; */
			}
			
		
			if($this->input->post("visibility", true) == "true")
			{
				$data['public'] = true;
			}
			else if($this->input->post("visibility", true) == "false")
			{
				$data['public'] = false;
			}
			
			if(trim($this->input->post("description", true)) != "")
			{
				$data['item_description'] = trim($this->input->post("description", true));
			}
			
			
			
			$this->db->set($data);
			$this->db->where("ad_id", $this->TPL['ad_id']);
			if($this->db->update("ADS"))
			{
				if($_FILES['image']['name'] != "")
				{
					$exists = $this->db->like('ad_id', $this->TPL['ad_id'])
						->limit(1)
						->from("IMAGES")
						->count_all_results() > 0;
					if($exists)
					{
						$this->db->set(array("image_location"=> $this->TPL['image_location']));
						$this->db->where("ad_id", $this->TPL['ad_id']);
						$this->db->update("IMAGES");
					}
					else
					{
						$this->db->insert("IMAGES", array("owner_id"=> $this->ion_auth->user()->row()->id,"image_location"=> $this->TPL['image_location'], "ad_id" => $this->TPL['ad_id']));
					}
				}
				$this->TPL['success'] = true;
				$this->TPL['success_msg'] = "";
				redirect("c=ad&ad=". $this->TPL['ad_id']);
			}
		}
		else
		{
			
			$this->TPL['error'] = true;
			$this->get_ad($this->TPL['ad_id'], $this->ion_auth->user()->row()-id);
			$this->template->show('edit_ad', $this->TPL);
		}
		
	}
	
	/*
		Like in the post an ad controller this gets the data for categories, and manufacturers so the user may apply one to their ad.
	*/
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
	
	/*
		This validates the condition to ensure it is a real condition and not some means of adding something to the database.
	*/
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
	
	/*
		This validates the manufacturer to ensure it is a real manufacturer and not some means of adding something to the database.
	*/
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

	/*
		This validates the brand to ensure it is a real brand and not some means of adding something to the database.
	*/
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
	
	/*
		This validates the price and makes sure it is greater than 0.
	*/
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
	/*
		This function checks the category to see if it exists.
	*/
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
	
	/* 
		This is the upload validation it attempts to upload a image and returns true if successful.
	*/
	public function _upload_validation()
	{
		$config['upload_path'] = './uploads/';
		$config['allowed_types'] = 'gif|jpeg|png|jpg';
		$config['max_size'] = '10000';
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
			return true;
		}
		
	}
	
	/*
		This method vaildates the user changes and then applies them to the database.
	*/
	public function edit_user_submit()
	{
		
		$this->form_validation->set_rules('is_valid', 'Confirm information', 'required');
		$this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
		
		$id = $this->ion_auth->user()->row()->id;
		$data;
		
		if(trim($this->input->post("password", true)) != "")
		{
			$this->form_validation->set_rules('password', 'Password', 'min_length[10]');
			$data['password'] = trim($this->input->post("password", true));
		}
		
		if(trim($this->input->post("password", true)) != "")
		{
			$this->form_validation->set_rules('confirm_password', 'Password confirmation', 'callback_match_password');
		}
		
		if(trim($this->input->post("sec_question", true)) != "")
		{
			$data['recovery_question'] = trim($this->input->post("sec_question", true));
		}
		
		if(trim($this->input->post("sec_answer", true)) != "")
		{
			$data['recovery_answer'] = trim($this->input->post("sec_answer", true));
		}
		
		if(trim($this->input->post("email", true)) != "")
		{
			$this->form_validation->set_rules('email', 'Email', 'valid_email');
			$data['email'] = trim($this->input->post("email", true));
		}
		
		if(trim($this->input->post("confirm_email", true)) != "")
		{
			$this->form_validation->set_rules('confirm_email', 'Email confirmation', 'callback_match_email');
		}
		
		if(trim($this->input->post("fname", true)) != "")
		{
			$this->form_validation->set_rules('fname', 'First name', 'alpha');
			$data['first_name'] = trim($this->input->post("fname", true));
		}
		
		if(trim($this->input->post("lname", true)) != "")
		{
			$this->form_validation->set_rules('lname', 'Last name', 'alpha');
			$data['last_name'] = trim($this->input->post("lname", true));
		}
		
		if(trim($this->input->post("city", true)) != "")
		{
			$data['city'] = trim($this->input->post("city", true));
		}
		
		if(trim($this->input->post("address", true)) != "")
		{
			$data['address'] = trim($this->input->post("address", true));
		}
		
		if(trim($this->input->post("province", true)) != "")
		{
			$this->form_validation->set_rules('province', 'Province', 'alpha');
			$data['province'] = trim($this->input->post("province", true));
		}
		
		if($this->form_validation->run() == true)	
		{
			$this->ion_auth->update($id, $data);
			$this->TPL['success'] = true;
			$this->TPL['success_msg'] = "Account successfully updated";
			$this->edit_user();
		}
		else
		{
			$this->TPL['error'] = true;
			$this->edit_user();
		}
				
	}
	
	/*
		This method ensures the passwords match.
	*/
	public function match_password($pass)
	{
		
		if($pass != $_POST['password'])
		{
			$this->form_validation->set_message('match_password', 'The Password fields must match.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/*
		This method ensures the passwords match.
	*/
	public function match_email($email)
	{
		if($email != $_POST['email'])
		{
			$this->form_validation->set_message('match_email', 'The Email fields must match.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}