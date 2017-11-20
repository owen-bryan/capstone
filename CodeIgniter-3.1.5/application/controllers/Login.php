<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Log in";
		$this->TPL['loggedIn'] = false;
		
		if($this->user_auth->validSessionExists())
		{
			$this->user_auth->redirect($_SESSION['base_page']);
		}
		
	}
	
	public function index()
	{
		
		$this->template->show('login', $this->TPL);
		
		
	}
	
	public function login()
	{
		$username = $this->input->post('uname', true);
		$password = $this->input->post('password', true);
		
		$this->TPL['error'] = $this->user_auth->login($username, $password);
		echo $this->TPL['error'];
	}

	public function log_out()
	{
		$this->user_auth->logout();
	}
	
	public function forgot_password()
	{
		$this->template->show("forgot_password", $this->TPL);
	}
	
	public function forgot_password_question()
	{
		$username = $this->input->post("uname", true);
		
		$sql = "SELECT `recovery_question` FROM `USERS` WHERE `user_name`= ? ;";
		$query = $this->db->query($sql, $username);
		if($query)
		{
			$row = $query->row_array();
			
			if(isset($row))
			{
				$this->template->show("forgot_password", $this->TPL);
			}
		}
	}
}