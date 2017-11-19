<?php 
defined('BASEPATH') or exit('No direct script access allowed');

class SearchHelp extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		
		
		$this->user_auth->redirect(base_url . "index.php?/Search/search/" . $this->input->post(search_string));
		

	}
	
}