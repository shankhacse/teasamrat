<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Home extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('usermodel','',TRUE);
	
 }
	
 function index()
 {
   
   if($this->session->userdata('logged_in'))
   {
     /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = null;
	 $page = 'welcome_view';
	 $header = '';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	 createbody_method($result,$page,$header,$session);
		
 	}
	else
   {
     //If no session, redirect to login page
     redirect('login', 'refresh');
   }
 }

	
 function logout()
 {
   $this->session->unset_userdata('logged_in');
   $this->session->unset_userdata('logged_in_details');
   $this->session->unset_userdata('purchase_invoice_list_detail');
   $this->session->unset_userdata('unreleaseddo_list_invoice');
   
   session_destroy();
   redirect('login', 'refresh');
 }

}

?>