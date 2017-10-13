<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Signup extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Signup";
		$this->TPL['loggedIn'] = false;
		
	}
	
	public function index()
	{
		
		$this->template->show('signup', $this->TPL);
	}
	
	public function addUser()
	{
		$password = $this->input->post('password',true);
		
		$options = [
			'cost' => 11
		];
		
		$hash = password_hash($password, PASSWORD_DEFAULT, $options);
		
		
		$sign_up_data = [ 
		'username' => $this->input->post('uname',true),
		'email' => $this->input->post('email',true),
		'hash' => $hash,
		'fname' => $this->input->post('fname',true),
		'lname' => $this->input->post('lname',true),
		'city' => $this->input->post('city', true),
		'address' => $this->input->post('address',true),
		'province' => $this->input->post('province',true),
		'user_role_id' => 1,
		'sec_question' => $this->input->post('sec_question',true), 
		'sec_answer' => $this->input->post('sec_answer',true)
		];
		
		
		$sql = "INSERT INTO `USERS`(`user_name`, `email`,`hash`, `first_name`, `last_name`, `city`, `address`, `province`, `user_role_id`, `recovery_question`, `recovery_answer`) VALUES (?,?,?,?,?,?,?,?,?,?,?);";
		
		$query = $this->db->query($sql, $sign_up_data);
		
		
	}
}
