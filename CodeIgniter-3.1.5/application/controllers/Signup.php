<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Signup extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Sign up";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		$this->TPL['admin'] = $this->ion_auth->is_admin();
		
		
	}
	
	public function index()
	{
		if($this->TPL['loggedIn'] == true)
		{
			redirect("c=home");
		}
		else
		{
			$this->template->show('signup', $this->TPL);
		}
		
	}
	
	public function add_user()
	{
		$this->form_validation->set_rules('uname', 'Username', 'required|callback_is_available');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[10]');
		$this->form_validation->set_rules('confirm_password', 'Password confirmation', 'callback_match_password');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('confirm_email', 'Email confirmation', 'callback_match_email');
		$this->form_validation->set_rules('sec_question', 'Security question', 'required');
		$this->form_validation->set_rules('sec_answer', 'Security answer', 'required');
		$this->form_validation->set_rules('fname', 'First name', 'required|alpha');
		$this->form_validation->set_rules('lname', 'Last name', 'required|alpha');
		$this->form_validation->set_rules('address', 'Street address', 'required');
		$this->form_validation->set_rules('city', 'City', 'required');
		$this->form_validation->set_rules('province', 'Province', 'required');
		$this->form_validation->set_rules('is_valid', 'Confirm information', 'required');
		$this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
		
		if($this->form_validation->run() == true){
			$username = $this->input->post('uname',true);
			$password = $this->input->post('password',true);
			
			$options = [
				'cost' => 11
			];
			
			$hash = password_hash($password, PASSWORD_DEFAULT, $options);
			
			
			$sign_up_data = [ 
			'username' => $username,
			'email' => $this->input->post('email',true),
			'hash' => $hash,
			'fname' => $this->input->post('fname',true),
			'lname' => $this->input->post('lname',true),
			'city' => $this->input->post('city', true),
			'address' => $this->input->post('address',true),
			'province' => $this->input->post('province',true),
			'sec_question' => $this->input->post('sec_question', true), 
			'sec_answer' => $this->input->post('sec_answer', true),
			'active' => 1
			];
			
			
			$sql = "INSERT INTO `USERS`(`user_name`, `email`,`password`, `first_name`, `last_name`, `city`, `address`, `province`, `recovery_question`, `recovery_answer`, `active`) VALUES (?,?,?,?,?,?,?,?,?,?,?);";
			$sql2 = "INSERT INTO `USERS_GROUPS` (`user_id`, `group_id`) VALUES ((SELECT `id` from `USERS` WHERE `user_name` LIKE ?), 1);";
			$query = $this->db->query($sql, $sign_up_data);
			
			if($query)
			{
				$this->db->query($sql2, $username);
				$this->TPL['name'] = $this->input->post('fname',true);
				$this->TPL['uname'] = $this->input->post('uname', true);
				$this->template->show("sign_up_success", $this->TPL);
			}
			else
			{
				$this->TPL['message'] = true;
				$this->TPL['message_body'] = "Unknown error occurred";
				$this->template->show("signup", $this->TPL);
			}
		}
		else
		{
			$this->TPL['message'] = true;
			$this->template->show("signup", $this->TPL);
		}
	}
	
	public function is_available($str)
	{
		$exists = $this->db->like('user_name', $str)
						->limit(1)
						->from("USERS")
						->count_all_results() > 0;
		if(!$exists)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('is_available', 'That Username is not available.');
			return false;
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
