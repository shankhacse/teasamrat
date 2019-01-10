<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//we need to call PHP's session object to access it through CI
class Accountmaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('accountmastermodel','',TRUE);
   $this->load->model('groupmastermodel','',TRUE);

	
 }
	
 function index()
 {
   
   if($this->session->userdata('logged_in'))
   {
     /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->accountmastermodel->accountlist($session);
	 $headercontent['groupmastername'] = $this->groupmastermodel->groupmasterlist();
	
	 
	 $page = 'account_master/list_view';
	 $header = 'account_master/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session,$headercontent);
		
 	}
	else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }
 
 	function add()
 	{
		// $this->load->helper('sessiondata_helper');
	 	 $session = sessiondata_method();
		 
		 $value['account_name'] = $this->input->post('accname');
		 $value['group_master_id'] = $this->input->post('groupid');
		 $value['opening_balance'] = $this->input->post('balance');
		 $value['company_id'] = $session['company'];
		 $value['financialyear_id'] = $session['yearid'];
						

		 if (isset($_POST))
		 {
			$id =  $this->accountmastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		  
		 $value['account_name'] = $this->input->post('accname');
		 $value['group_master_id'] = $this->input->post('groupid');
		 $value['opening_balance'] = $this->input->post('balance');
		  $value['accblnceid'] = $this->input->post('accblnceid');
		 
		 $value['id'] = $this->input->post('id');
		
		if (isset($_POST))
		 {
			$res = $this->accountmastermodel->modify($value);
			echo $res;
      		
		 }
	 
	}
	
	function delete()
	{
		$value['parentid'] = $this->input->post('parentid');
		$value['childid'] = $this->input->post('childid');
		
		$status = $this->accountmastermodel->delete($value);
		echo $status;
	}
}

?>