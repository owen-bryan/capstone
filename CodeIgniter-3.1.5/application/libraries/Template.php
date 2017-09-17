<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class Template
{

	function show($view, $args = NULL)
	{
		$CI =& get_instance();
		
		$CI->load->view('header',$args);
		$CI->load->view($view, $args);
	}
	
}