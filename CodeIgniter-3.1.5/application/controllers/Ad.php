<?php
defined('BASEPATH') or exit('No direct script access allowed!');
/*
	Class by: Owen Bryan, 000340128.
*/
class Ad extends CI_Controller
{	
	var $TPL;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->TPL['page'] = "Ad";
		$this->TPL['loggedIn'] = $this->ion_auth->logged_in();
		$this->TPL['admin'] = $this->ion_auth->is_admin();
		
		
	}
	
	public function index()
	{
		$this->get_ad($this->input->get('ad', true));
		
		/* echo "<pre>";
		print_r($this->TPL);
		//print_r($_SESSION);
		echo "</pre>"; */
		if(isset($this->TPL['details']['ad_title']))
		{
			$this->template->show("ad",$this->TPL);
		}
		else
		{
			redirect('c=search&m=display');
		}
	}
	
	public function sold()
	{
		$this->TPL['sold'] = true;
		$this->TPL['sold_id']  = $this->input->get("ad", true);
		
		$this->get_ad($this->TPL['sold_id']);
		$this->template->show("ad", $this->TPL);
	}
	
	public function sold_confirmed()
	{
		$this->TPL['ad_id'] = $this->input->get("ad", true);
		$uid =  $this->ion_auth->user()->row()->id;
		$exists = $this->db->like('ad_id', $ad_id)
						->limit(1)
						->from("ADS")
						->count_all_results() > 0;
						
		if($exists)
		{
			$this->db->reset_query();
			$query = $this->db->query('SELECT * FROM `ADS` WHERE `ad_id`= ? AND `user_id` = ?', array($this->TPL['ad_id'], $uid));

			
			$results = $query->row()->ad_id;
			if($results > 0)
			{
				$this->db->set(array("sold" => 1));
				$this->db->where("ad_id", $this->TPL['ad_id']);
				if($this->db->update("ADS"))
				{
					$this->TPL['message'] = "Ad marked as sold";
					$this->template->show("message",$this->TPL);
				}
			}
			else
			{
				$this->get_ad($this->TPL['ad_id']);
				$this->template->show("ad",$this->TPL);
			}
		}
		else
		{
			redirect("c=search&m=display");
		}
	}
	
	public function delete_ad()
	{
		$ad_id = $this->input->get("ad", true);
		$exists = $this->db->like('ad_id', $ad_id)
				->limit(1)
				->from("ADS")
				->count_all_results() > 0;
		if($exists)
		{
			$this->TPL['delete'] = true;
			$this->TPL['ad_id'] = $ad_id;
			$this->get_ad($ad_id);
			
			$this->template->show("ad",$this->TPL);
		}
	}
	
	public function delete_confirmed()
	{
		$ad_id = $this->input->get("ad", true);
		$uid = $this->ion_auth->user()->row()-id;
		$exists = $this->db->like('ad_id', $ad_id)
				->limit(1)
				->from("ADS")
				->count_all_results() > 0;
		if($exists)
		{
			$uid = $this->ion_auth->user()->row()->id;
			$query = $this->db->query('SELECT * FROM `ADS` WHERE `ad_id`= ? AND `user_id` = ?', array($ad_id, $uid));
			$results = $query->row()->ad_id;
			if($results > 0)
			{
				$this->db->set(array("deleted" => 1));
				$this->db->where("ad_id", $ad_id);
				if($this->db->update("ADS"))
				{
					
					$this->TPL['message'] = "Your ad has been deleted";
					$this->template->show("message",$this->TPL);
				}
			}
			else
			{
				redirect("c=search");
			}
		}
	}
	
	public function report_ad()
	{
		$ad_id = $this->input->get("ad", true);
		$exists = $this->db->like('ad_id', $ad_id)
						->limit(1)
						->from("ADS")
						->count_all_results() > 0;
		if($exists)
		{
			$this->db->set(array("reported" => 1));
			$this->db->where("ad_id", $ad_id);
			
			if($this->db->update("ADS"))
			{
				$this->TPL['message'] = "Thanks for reporting this ad. Our Admins will investigate and judge this ad as soon as possible";
				$this->template->show("message", $this->TPL);
			}
			
			
		}
	}

	
	private function get_ad($id)
	{
		$this->db->select('ADS.ad_id, item_description, views, ad_title, item_condition, item_price, post_date, sold, reported, user_name, image_location, address, city, province, USERS.id, USERS.user_name');
		$this->db->from('ADS');
		$this->db->join('USERS', 'ADS.user_id = USERS.id');
		$this->db->join('IMAGES', 'ADS.ad_id = IMAGES.ad_id', "left");
		$this->db->where('ADS.ad_id', $this->input->get('ad', true));
		
		if(!$this->TPL['admin'])
		{
			$this->db->where('reported', 0);
		}
		
		$query = $this->db->get();
		
		if($query)
		{
			$result = $query->row_array();
			if($this->TPL['details']['reported'] && $this->TPL['admin'])
			{
				$this->TPL['details'] = $result ;
			}
			if($this->TPL['details']['sold'] && $this->TPL['id'] == $this->ion_auth->user()->row()->id)
			{
				$this->TPL['details'] = $result ;
			}
			else
			{
				$this->TPL['details'] = $result ;
			}
			if($this->TPL['details']['image_location'] == null)	
			{
				$this->TPL['details']['image_location'] = "default.jpg";
			}
		}
		else
		{
			$this->TPL['message'] = "No such ad exists";
			$this->template->show("message", $this->TPL);
		}
	}
	
}