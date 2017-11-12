<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "User";
		$this->TPL['loggedIn'] = $this->user_auth->validSessionExists();;
		
	}
	
	public function index()
	{
		
		$this->template->show('user', $this->TPL);
	}

}