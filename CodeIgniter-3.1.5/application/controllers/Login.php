<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Log in";
		$this->TPL['loggedIn'] = $this->user_auth->validSessionExists();;
		
	}
	
	public function index()
	{
		
		$this->template->show('login', $this->TPL);
		
		
	}
	
	public function login()
	{
		
		$password = $this->input->post('password', true);
		echo $password;
		
		$sql = "SELECT hash FROM USERS WHERE user_name=?;";
		$query = $this->db->query($sql, array($this->input->post('uname', true)));
		
		
		if ($query){
			$row = $query->row_array();
			if( password_verify($password, $row['hash'])){
				echo "success";
			}
		}
	}

}