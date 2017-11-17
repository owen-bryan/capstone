<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class User_auth {
	
	private $username = "";
	private $password = "";
	private $accessLevel = "";
	private $banned = "";
	
	private $login_page = "";
	private $logout_page = "";
	
	function __construct() 
    {
      error_reporting(E_ALL & ~E_NOTICE);
      $this->login_page = base_url() . "index.php?/Login";
      $this->logout_page = base_url() . "index.php?/Home";
    }
	
	function loggedin($page){
		if($this->validSessionExists() == false)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function validSessionExists() 
    {
      session_start();
      if (!isset($_SESSION['username']))
      {
        return false;
      }
      else
      {
        return true;
      }
    }
	
	public function redirect($page)
	{
		header("Location: " . $page);
		exit();
	}
}