<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Home";
		$this->TPL['loggedIn'] = false;
		
	}
	
	public function index()
	{
		
		$this->template->show('home', $this->TPL);
	}

}