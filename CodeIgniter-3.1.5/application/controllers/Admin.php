<?php 
defined('BASEPATH') or exit('No direct script access allowed');
/*
	Class by: Owen Bryan, 000340128.
*/
class Admin extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Admin";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		$this->TPL['admin'] = $this->ion_auth->is_admin();
		$this->TPL['username'] = $this->ion_auth->user()->row()->user_name;
		
		if($this->TPL['admin'] == false || $this->TPL['loggedIn'] == false)
		{
			redirect("c=home");
		}
	}
	
	/*
		Display a the base admin pane.
	*/
	public function index()
	{
		
		$this->template->show('admin', $this->TPL);
		
	}
	
	/*
		Display a the new manufacturer form.
	*/
	public function manufacturer()
	{
		
		$this->template->show('new_manufacturer', $this->TPL);
	}
	
	
	/*
		Display a the new categories form.
	*/
	public function category()
	{
		$this->template->show('new_category', $this->TPL);
	}
	
	/*
		Display a prompt to the admin for banning an user.
	*/
	public function ban_user()
	{
		$this->TPL['user_id'] = $this->input->get('user',true);
		$this->template->show("ban", $this->TPL);
	}
	
	/*
		Display a prompt to the admin for forgiving an user.
	*/
	public function forgive_user()
	{
		$this->TPL['user_id'] = $this->input->get('user',true);
		if(isset($_GET['ad']))
		{
			
			$this->TPL['ad_id'] = $this->input->get('ad',true);
		}
		else
		{
			$this->TPL['message_id'] = $this->input->get('mid',true);
		}
		$this->template->show("forgive", $this->TPL);
	}
	
	/*
		This function submits the confirmed banned user and deletes all their ads.
	*/
	public function ban_user_submit()
	{
		$this->TPL['user_id'] = $this->input->post('user',true);
		if(trim($this->TPL['user_id']) != "")
		{
			$exists = $this->db->like('id', $this->TPL['user_id'])
						->limit(1)
						->from("USERS")
						->count_all_results() > 0;
			if($exists)
			{
				$query = $this->db->query('SELECT * FROM `ADS` WHERE `user_id` = ? and `reported` = 1', array($this->TPL['user_id']));
				$results = $query->row()->ad_id;
				
				if($results > 0 )
				{
						
					$this->db->set(array("banned" => 1));
					$this->db->where("id",  $this->TPL['user_id']);
					if($this->db->update("USERS"))
					{
						$this->db->set(array("deleted" => 1));
						$this->db->where("user_id",  $this->TPL['user_id']);
						if($this->db->update("ADS"))
						{
							$this->TPL['message'] = "Successfully banned user";
							$this->template->show("message", $this->TPL);
						}
					}
					else
					{
						$this->TPL['message'] = "Unsuccessfully banned user";
						$this->template->show("message", $this->TPL);
					}
				}
				else
				{
					$this->TPL['message'] = "Cannot ban user. They have no open reports.";
					$this->template->show("message", $this->TPL);
				}
			}
			else
			{
				$this->TPL['message'] = "No such user exists";
				$this->template->show("message", $this->TPL);
			}
		}
		
	}
	
	/*
		This function forgives the user and the inputed ad in the database
	*/
	public function forgive_user_submit()
	{
		$this->TPL['user_id'] = $this->input->post('user',true);
		if(isset($_POST['ad']))
		{
			$this->TPL['ad_id'] = $this->input->post('ad',true);
		}
		else
		{
			$this->TPL['message_id'] = $this->input->post('message',true);
		}
		if(trim($this->TPL['user_id']) != "")
		{
			$exists = $this->db->like('id', $this->TPL['user_id'])
						->limit(1)
						->from("USERS")
						->count_all_results() > 0;
			if($exists)
			{
				$results;
				if(isset($_POST['ad']))
				{
					$query = $this->db->query('SELECT * FROM `ADS` WHERE `user_id` = ? and ad_id = ? and `reported` = 1', array($this->TPL['user_id'], $this->TPL['ad_id']));
					$results = $query->row()->ad_id;
				}
				else
				{
					$query = $this->db->query('SELECT * FROM `MESSAGES` WHERE `from_user_id` = ? and message_id = ? and `reported` = 1', array($this->TPL['user_id'], $this->TPL['message_id']));
					$results = $query->row()->message_id;
				}
				
				
				if($results > 0 )
				{
						
					$this->db->set(array("reported" => 0));
					if(isset($_POST['ad']))
					{
						$this->db->where("ad_id",  $this->TPL['ad_id']);
						if($this->db->update("ADS"))
						{
							$this->TPL['message'] = "User forgiven";
							$this->template->show("message", $this->TPL);
						}
					}
					else if(isset($_POST['message']))
					{
						$this->db->where("message_id",  $this->TPL['message_id']);
						if($this->db->update("MESSAGES"))
						{
							$this->TPL['message'] = "User forgiven";
							$this->template->show("message", $this->TPL);
						}
					}
					
					else
					{
						$this->TPL['message'] = "Error occurred no action taken";
						$this->template->show("message", $this->TPL);
					}
				}
				else
				{
					$this->TPL['message'] = "Cannot forgive user they have no reports.";
					$this->template->show("message", $this->TPL);
				}
			}
			else
			{
				$this->TPL['message'] = "No such user exists";
				$this->template->show("message", $this->TPL);
			}
		}
		
	}
	
	/*
		Display a the reported messages view.
	*/
	public function messages()
	{
		$this->get_reported_messages();
		$this->template->show("message_reported", $this->TPL);
	}
	
	/*
		Retreive the reported messages from the database.
	*/
	private function get_reported_messages()
	{
		$sql = "SELECT message_id, subject, date_sent, user_name, from_user_id FROM MESSAGES JOIN USERS ON MESSAGES.from_user_id = USERS.id WHERE reported = 1 AND banned = 0";
		$user_id = $this->ion_auth->user()->row()->id;
		
		$query = $this->db->query($sql, $user_id);
		
		if($query)
		{

			$results = $query->result_array();
			
			
			for($i = 0; $i < $query->num_rows(); $i++)
			{
				$this->TPL['messages'][$i]['message_id'] = $results[$i]['message_id'];
				$this->TPL['messages'][$i]['from_user_id'] = $results[$i]['from_user_id'];
				$this->TPL['messages'][$i]['subject'] = $results[$i]['subject'];
				$this->TPL['messages'][$i]['date_sent'] = date("Y-m-d", $results[$i]['date_sent']);
				$this->TPL['messages'][$i]['user_name'] = $results[$i]['user_name'];
			}
			
		}
	}
	
	/*
		Insert the new category into the database.
	*/
	public function new_category()
	{
		if(trim($this->input->post("category", true)) != "")
		{
			$category = trim($this->input->post("category", true));
			$exists = $this->db->like('category_name', $category)
							->limit(1)
							->from("CATEGORIES")
							->count_all_results() > 0;
			if($exists == false)	
			{
				$query = $this->db->insert("CATEGORIES", array("category_name"=>$category));
					
				if($query)
				{
					$this->TPL['success'] = true;
					$this->TPL['success_msg'] = "Category successfully added to Database";
						
					$this->category();
				}
				else
				{
					$this->TPL['error'] = true;
					$this->TPL['error_msg'] = "Category not successfully added to Database";
						
					$this->category();
				}
			}
			else
			{
				$this->TPL['error'] = true;
				$this->TPL['error_msg'] = "Category already in database";
				$this->category();
			}
		}
		else
		{
			$this->TPL['error'] = true;
			$this->TPL['error_msg'] = "Please type in a category";
			$this->category();
		}
	}
	
	/*
		Retrieve the manufactures and categories. Then display the new brand form.
	*/
	public function brand()
	{
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
		
		$this->template->show('new_brand', $this->TPL);
	}
	
	/*
		Insert the new brand into the database.
	*/
	public function new_brand()
	{
		if(trim($this->input->post("brand", true)) != "")
		{
			$manufacturer = $this->input->post("manufacturer", true);
			$exists = $this->db->like('manufacturer_id', $manufacturer)
							->limit(1)
							->from("MANUFACTURERS")
							->count_all_results() > 0;
			if($exists == true)
			{
				$brand_name = $this->input->post("brand", true);
				
				$data = array("brand_name" => $brand_name, "manufacturer_id" => $manufacturer);
				if(trim($this->input->post("category")) != "")
				{
					if($this->db->like('category_id', $this->input->post("category", true))
							->limit(1)
							->from("CATEGORIES")
							->count_all_results() > 0)
							{	
								$data['category'] =  $this->input->post("category", true);
							}
				}
				$query = $this->db->insert("BRANDS", array("brand_name"=>$brand_name, "manufacturer_id" => $manufacturer));
				
				if($query)
				{
					$this->TPL['success'] = true;
					$this->TPL['success_msg'] = "Manufacturer successfully added to Database";
						
					$this->template->show("new_brand", $this->TPL);
				}
			}
			else
			{
				$this->TPL['error'] = true;
				$this->TPL['error_msg'] = "No such manufacturer in Database";
						
				$this->brand();
			}
		}
		else
		{
			$this->TPL['error'] = true;
			$this->TPL['error_msg'] = "Please type in a brand.";
			$this->category();
		}
	}
	/*
		Insert the new manufacturer into the database.
	*/
	public function new_manufacturer()
	{
		if(trim($this->input->post("manufacturer", true)) != "")
		{
			$manufacturer = trim($this->input->post("manufacturer", true));
			$exists = $this->db->like('manufacturer_name', $manufacturer)
						->limit(1)
						->from("MANUFACTURERS")
						->count_all_results() > 0;
			if($exists == false)
			{
				$query = $this->db->insert("MANUFACTURERS", array("manufacturer_name"=>$manufacturer));
				
				if($query)
				{
					$this->TPL['success'] = true;
					$this->TPL['success_msg'] = "Manufacturer successfully added to Database";
					
					$this->manufacturer();
				}
				else
				{
					$this->TPL['error'] = true;
					$this->TPL['error_msg'] = "Manufacturer not successfully added to Database";
					
					$this->manufacturer();
				}
			}
			else
				{
					$this->TPL['error'] = true;
					$this->TPL['error_msg'] = "Manufacturer already in Database";
					
					$this->manufacturer();
				}
		}
	}

}