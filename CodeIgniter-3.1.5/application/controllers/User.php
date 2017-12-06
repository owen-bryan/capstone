<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "User";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		
	}
	
	public function index()
	{
		
		$this->template->show('user', $this->TPL);
	}

}