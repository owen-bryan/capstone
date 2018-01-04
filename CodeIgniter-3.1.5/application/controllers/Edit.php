<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Edit extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		$this->TPL['admin'] = $this->ion_auth->is_admin();
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