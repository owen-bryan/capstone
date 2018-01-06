<?php 
defined('BASEPATH') or exit('No direct script access allowed');
/*
	Class by: Owen Bryan, 000340128.
*/
class Login extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Log in";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		$this->TPL['admin'] = $this->ion_auth->is_admin();
		$this->TPL['username'] = $this->ion_auth->user()->row()->user_name;
		
		
		
	}
	
	public function index()
	{
		if(!$this->ion_auth->logged_in())
		{
			$this->template->show('login', $this->TPL);
		}
		else
		{
			redirect("c=home");
		}
	}
	
	/*
		Main login function. It checks if the user is banned, then attempts to log them in.
	*/
	public function login()
	{
		$username = $this->input->post('uname', true);
		$password = $this->input->post('password', true);
		$banned = $exists = $this->db->like('banned', 1)->like('user_name', $username)
						->limit(1)
						->from("USERS")
						->count_all_results() > 0;
		if($banned == false)
		{
			if($this->ion_auth->login($username, $password))
			{
				redirect("c=home");
			}
			else
			{
				$this->TPL['error'] = true;
				$this->TPL['error_msg'] = "Invalid username or password";
				$this->template->show('login', $this->TPL);
			}
			
		}
		else
		{
			$this->TPL['error'] = true;
			$this->TPL['error_msg'] = "That account has been banned";
			$this->template->show('login', $this->TPL);
		}
	}

	/*
		This method logs out a logged in user.
	*/
	public function log_out()
	{
		$this->ion_auth->logout();
		redirect("c=login");
	}
	
	/*
		This begins the password recover for the user.
	*/
	public function forgot_password()
	{
		$this->template->show("forgot_password", $this->TPL);
	}
	
	/*
		This is the first step of password recovery. It checks if the user exists then gets the recovery question from the database.
	*/
	public function forgot_password_question()
	{
		$username = $this->input->post("uname", true);
		
		$exists = $this->db->like('user_name', $username)
						->limit(1)
						->from("USERS")
						->count_all_results() > 0;
		if($exists == true)
		{
			$sql = "SELECT `recovery_question`, `id` FROM `USERS` WHERE `user_name`= ? ;";
			$query = $this->db->query($sql, $username);
			if($query)
			{
				$row = $query->row_array();
				
				if(isset($row))
				{
					$this->TPL['question'] = $row['recovery_question'];
					$this->TPL['uid'] = $row['id'];
					$this->template->show("reset_question", $this->TPL);
				}
				else
				{
					$this->TPL['error'] = true;
					$this->TPL['error_msg'] = "Invalid input or no such user exists";
					$this->template->show("forgot_password", $this->TPL);
				}
			}
		}
		else
		{
			$this->TPL['error'] = true;
			$this->TPL['error_msg'] = "No such user exists.";
			$this->template->show("forgot_password", $this->TPL);
		}
		
		
	}
	
	/*
		This is the second step of password recovery. It checks if the user inputted the correct answer, then, if correct allows them to change their password.
	*/
	public function forgot_password_answer()
	{
		$this->TPL['uid'] = $this->input->post('uid', true);
		$answer = $this->input->post('answer', true);
		$sql = "SELECT `recovery_answer`, `recovery_question` FROM `USERS` WHERE `id`= ? ;";
		$query = $this->db->query($sql, $this->TPL['uid']);
		if($query)
		{
			$row = $query->row_array();
			
			if(isset($row))
			{
				$true_answer = $row['recovery_answer'];
				if($answer == $true_answer)
				{
					$this->template->show("reset", $this->TPL);
				}
				else
				{
					$this->TPL['error'] = true;
					$this->TPL['error_msg'] = "Invalid or incorrect answer";
					$this->TPL['question'] = $row['recovery_question'];
					$this->template->show("reset_question", $this->TPL);
					
				}
			}
		}
	}
	
	/*
		This is the final step of password recovery. It validate the password then sets the user's password in the database if valid..
	*/
	public function reset_password()
	{
		$this->form_validation->set_rules('pword', 'Password', 'required|trim|min_length[10]');
		$this->form_validation->set_rules('pword_confirm', 'Password confirmation', 'trim|callback_match_password|required');
		$this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
		if($this->form_validation->run() == true)
		{
			$this->ion_auth->update($this->input->post("uid", true), array("password"=>$this->input->post("pword", true)));
			$this->TPL['success'] = true;
			$this->TPL['success_msg'] = "Password successfully changed";
			$this->template->show("reset", $this->TPL);
		}
		else
		{
			$this->TPL['uid'] = $this->input->post("uid", true);
			$this->TPL['error'] = true;
			$this->template->show("reset", $this->TPL);
		}
			
	}
	
	
	/*
		validate password function. It checks the the passwords match.
	*/
	public function match_password($str)
	{
		if($str == trim($_POST['pword']))
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message("match_password", "The password must match");
			return false;
		}
	}
	
}