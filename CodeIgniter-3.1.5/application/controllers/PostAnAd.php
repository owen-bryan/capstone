<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PostAnAd extends CI_Controller {
	
	
	var $TPL;
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Post an ad";
		$this->TPL['loggedin'] = $this->user_auth->validSessionExists();
		
	}

	public function index()
	{
		$this->template->show('postanad', $this->TPL);
	}

}