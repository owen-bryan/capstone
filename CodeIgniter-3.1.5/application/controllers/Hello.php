<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Hello extends CI_Controller {
	
	var $TPL;
	
	public function __contruct()
	{
		parent::__contruct();
		
	}
	
	public function index()
	{
		$this->TPL['page'] = "Home";
		$this->TPL['loggedIn'] = false;
		$this->TPL['hello'] = "hello world";
		$this->template->show('hello', $this->TPL);
	}

}