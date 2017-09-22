<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Admin";
		$this->TPL['loggedIn'] = false;
		
	}
	
	public function index()
	{
		
		$this->template->show('admin', $this->TPL);
	}

}