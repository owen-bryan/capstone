<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Post an ad";
		$this->TPL['loggedIn'] = $this->user_auth->loggedin(base_url() . "index.php?/PostAnAd");
		
	}
	
	public function index()
	{
		
		$this->template->show('admin', $this->TPL);
	}

}