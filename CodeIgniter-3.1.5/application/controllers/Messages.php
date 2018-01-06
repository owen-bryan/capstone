<?php 
defined('BASEPATH') or exit('No direct script access allowed');
/*
	Class by: Owen Bryan, 000340128.
*/
class Messages extends CI_Controller {
	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Messages";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		$this->TPL['admin'] = $this->ion_auth->is_admin();
		$this->TPL['username'] = $this->ion_auth->user()->row()->user_name;	
		if($this->TPL['loggedIn'] == false)
		{
			$this->TPL['error'] = true;
			$this->TPL['error_msg'] = "You must be logged in to access this page";
			
			$this->TPL['page'] = "Log in";
			
			$this->template->show("login", $this->TPL);
		}
		
	}
	
	public function index()
	{
		$this->inbox();
		
	}
	
	/*
		Get the users messages and display the inbox view.
	*/
	public function inbox()
	{
		$this->get_messages();
		$this->TPL['title'] = "Inbox";
		$this->template->show("messages", $this->TPL);
			
	}
	
	/*
		Get the requested message and display message to the user.
	*/
	public function view_message()
	{
		$this->TPL['message_id'] = $this->input->get('mid', true);
		
		$query = $this->db->query("SELECT * FROM MESSAGES JOIN USERS ON from_user_id = id WHERE message_id = ? and reported = 0 and banned = 0", $this->TPL['message_id']);
		if($query)
		{
			$results = $query->row_array();
			
			$this->TPL['message'] = $results;
			$this->template->show("display_message", $this->TPL);
		}
	}
	
	/*
		Function to retrieve inbox messages
	*/
	private function get_messages()
	{
		$sql = "SELECT message_id, subject, date_sent, user_name FROM MESSAGES JOIN USERS ON MESSAGES.from_user_id = USERS.id WHERE reported = 0 AND banned = 0 AND to_user_id = ?";
		$user_id = $this->ion_auth->user()->row()->id;
		
		$query = $this->db->query($sql, $user_id);
		
		if($query)
		{

			$results = $query->result_array();
			
			
			for($i = 0; $i < $query->num_rows(); $i++)
			{
				$this->TPL['messages'][$i]['message_id'] = $results[$i]['message_id'];
				$this->TPL['messages'][$i]['subject'] = $results[$i]['subject'];
				$this->TPL['messages'][$i]['date_sent'] = date("Y-m-d", $results[$i]['date_sent']);
				$this->TPL['messages'][$i]['user_name'] = $results[$i]['user_name'];
			}
			
		}
	}

	/*
		Function to retrieve sent messages.
	*/
	private function get_sent_messages()
	{
		$sql = "SELECT message_id, subject, date_sent, user_name FROM MESSAGES JOIN USERS ON MESSAGES.to_user_id = USERS.id WHERE reported = 0 AND banned = 0 AND from_user_id = ?";
		$user_id = $this->ion_auth->user()->row()->id;
		
		$query = $this->db->query($sql, $user_id);
		
		if($query)
		{

			$results = $query->result_array();
			
			
			for($i = 0; $i < $query->num_rows(); $i++)
			{
				$this->TPL['messages'][$i]['message_id'] = $results[$i]['message_id'];
				$this->TPL['messages'][$i]['subject'] = $results[$i]['subject'];
				$this->TPL['messages'][$i]['date_sent'] = date("Y-m-d", $results[$i]['date_sent']);
				$this->TPL['messages'][$i]['user_name'] = $results[$i]['user_name'];
			}
			
		}
	}
	/*
		Get the preset details for the reply and display the new message form.
	*/
	public function reply()
	{
		$this->TPL['title'] = "New message";
		if(isset($_GET['ad']))
		{
			$this->TPL['ad_id'] = $this->input->get('ad',true);
		}
		if(isset($_GET['user']))
		{
			$this->TPL['user_id'] = $this->input->get('user',true);
		}
		if(isset($_GET['username']))
		{
			$this->TPL['name'] = $this->input->get('username',true);
		}
		
		$this->template->show("new_message", $this->TPL);
	}
	/*
		Get the preset details for the reply and display the new message form.
	*/
	public function new_message()
	{
		$this->TPL['title'] = "New message";
		if(isset($_GET['ad_id']))
		{
			$this->TPL['ad_id'] = $this->input->get('ad_id',true);
		}
		if(isset($_GET['user']))
		{
			$this->TPL['user_id'] = $this->input->get('user',true);
		}
		if(isset($_GET['username']))
		{
			$this->TPL['name'] = $this->input->get('username',true);
		}
		
		$this->template->show("new_message", $this->TPL);
	}
	
	/*
		Validation method for validating users.
	*/
	public function _validate_user($str)
	{
		$exists = $this->db->like('user_name', $str)
				->limit(1)
				->from("USERS")
				->count_all_results() > 0;
		if($exists)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message("_validate_user", "This user does not exist");
			return false;
		}
	}
	
	/*
		Get the details from the form and add a new message to database.
	*/
	public function send()
	{
		$this->TPL['title'] = "New message";
		$this->form_validation->set_rules("ad", "Ad", "trim");
		$this->form_validation->set_rules("to", "To", "trim|callback__validate_user|required");
		$this->form_validation->set_rules("body", "Body", "trim|required");
		
		$this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
		
		if($this->form_validation->run())
		{
			if(isset($_POST['ad']))
			{
				$this->TPL['ad_id'] = $this->input->post('ad',true);
			}
			
			if(isset($_POST['to']))
			{
				$this->TPL['name'] = $this->input->post('to',true);
			}
			if(isset($_POST['body']))
			{
				$this->TPL['body'] = $this->input->post('body',true);
			}
			if(isset($_POST['subject']))
			{
				$this->TPL['subject'] = $this->input->post('subject',true);
			}
			
			
			$toUser= $this->db->query("SELECT * FROM USERS WHERE user_name LIKE ?", $this->TPL['name']);
			$toUserID =  $toUser->row()->id;
			$fromUserID = $this->ion_auth->user()->row()->id;
				
			$data['to_user_id'] = $toUserID;
			$data['from_user_id'] = $fromUserID;
			if(isset($_POST['subject']))
			{
				$data['subject'] = $this->TPL['subject'];
			}
			$data['message'] = $this->TPL['body'];
			if(isset($_POST['ad']))
			{
				$data['ad_id'] = $this->TPL['ad_id'];
			}
			$data['date_sent'] = time();
			if($this->db->insert("MESSAGES", $data))
			{
				$this->get_messages();
				$this->TPL['title'] = "inbox";
				$this->template->show('messages', $this->TPL);
			}
			else
			{
				$this->TPL['message'] = "unknown error occurred. try again later";
				$this->template->show("message", $this->TPL);
			}
				
			
		}
		else
		{
			$this->TPL['error'] = true;
			$this->template->show("new_message", $this->TPL);
		}
	}
	
	/*
		Get the sent messages and display them to user.
	*/
	public function sent()
	{
		$this->get_sent_messages();
		$this->TPL['title'] = "Sent";
		$this->template->show("message_sent", $this->TPL);
			
	}
	
	/*
		Validate and set the message selected to reported.
	*/
	public function report()
	{
		$message_id = $this->input->get("mid", true);
		$exists = $this->db->like('message_id', $message_id)
						->limit(1)
						->from("MESSAGES")
						->count_all_results() > 0;
		if($exists)
		{
			$this->db->set(array("reported" => 1));
			$this->db->where("message_id", $message_id);
			
			if($this->db->update("MESSAGES"))
			{
				$this->TPL['message'] = "Thanks for reporting this message. Our Admins will investigate and judge this ad as soon as possible";
				$this->get_messages;
				$this->template->show("messages", $this->TPL);
			}
			
			
		}
	}
}