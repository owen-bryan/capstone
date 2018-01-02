<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Log in";
		$this->TPL['loggedIn'] = false;
		
		
		
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
	
	public function login()
	{
		$username = $this->input->post('uname', true);
		$password = $this->input->post('password', true);
		
		if($this->ion_auth->login($username, $password))
		{
			redirect("c=home");
		}
		else
		{
			$this->template->show('login', $this->TPL);
		}
	}

	public function log_out()
	{
		$this->ion_auth->logout();
		redirect("c=login");
	}
	
	public function forgot_password()
	{
		$this->template->show("forgot_password", $this->TPL);
	}
	
	public function forgot_password_question()
	{
		$username = $this->input->post("uname", true);
		
		$sql = "SELECT `recovery_question`, `id` FROM `USERS` WHERE `user_name`= ? ;";
		$query = $this->db->query($sql, $username);
		if($query)
		{
			$row = $query->row_array();
			
			if(isset($row))
			{
				$this->TPL['question'] = $row['recovery_question'];
				$this->TPL['uid'] = $row['id'];
				$this->template->show("reset", $this->TPL);
			}
		}
	}
	
	public function reset_password()
	{
		if(isset($_POST['pword']) && isset($_POST['pword_confirm']))
		{
			$this->ion_auth->update($this->input->post("uid", true), array("password"=>$this->input->post("pword", true)));
			redirect("c=home");
		}
	}
	
	
}