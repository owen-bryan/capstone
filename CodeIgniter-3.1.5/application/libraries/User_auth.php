<?php
defined('BASEPATH') or exit('No direct script access allowed!');

class User_auth {
	
	private $username = "";
	private $password = "";
	private $access_level = "";
	private $banned = false;
	private $user_id;
	
	private $login_page = "";
	private $logout_page = "";
	
	function __construct() 
    {
      error_reporting(E_ALL & ~E_NOTICE);
      $this->login_page = base_url() . "index.php?c=Login";
      $this->logout_page = base_url() . "index.php?c=Home";
    }
	
	public function login($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
		
		session_start();
		
		if($this->validSessionExists() == true)
		{
			$this->redirect($_SESSION['base_page']);
		}
		
		if($_SERVER['REQUEST_METHOD'] == "GET")
		{
			return;
		}
		
		if($this->userIsInDatabase() == false)
		{
			if($this->banned)
			{
				return "User is banned";
			}		
			else
			{
				return "Invalid username or password";
			}
		}
		else
		{
			$this->write_session();
			$this->redirect($_SESSION['base_page']);
		}
	}
	
	public function loggedin($page){
		session_start();
		
		if($this->validSessionExists() == false)
		{
			$this->redirect($this->login_page);
		}
		
		return true;
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
	
	public function logout() 
    {
      session_start(); 
      $_SESSION = array();
      session_destroy();
      header("Location: ".$this->logout_page);
    }
	
	public function userIsInDatabase()
	{
		$CI =& get_instance();
		
		$username = $this->username;
		$password = $this->password;
		$sql = "SELECT `user_id`, `user_name`, `hash`, `banned`, `role` FROM `USERS` JOIN `USER_ROLES` ON `USERS`.`user_role_id` = `USER_ROLES`.`user_role_id` WHERE `user_name`=?;";
		$query = $CI->db->query($sql, $username);
		$details = $query->row_array();
		
		if($query->num_rows() == 1)
		{
			if(password_verify($password, $details['hash']))
			{
				if($details['banned'] == false)
				{
					$this->access_level = $details['role'];
					$this->user_id = $details['user_id'];
					return true;
				}
				else
				{
					$this->banned = 1;
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}
	
	public function write_session()
	{
		$_SESSION['username'] = $this->username;
		$_SESSION['access_level'] = $this->access_level;
		$_SESSION['user_id'] = $this->user_id;
		
		if($this->access_level == "user")
		{
			$_SESSION['base_page'] =  base_url() . "index.php?c=Home";
		}
		else if($this->access_level == "admin")
		{
			$_SESSION['base_page'] = base_url() . "index.php?c=Admin";
		}
	}
	
	public function redirect($page)
	{
		header("Location: " . $page);
		exit();
	}
}