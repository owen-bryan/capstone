<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Post an ad";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		
	}
	
	public function index()
	{
		if($this->TPL['loggedIn'])
		{
			$this->template->show('admin', $this->TPL);
		}
		else
		{
			redirect("c=login");
		}
	}

}