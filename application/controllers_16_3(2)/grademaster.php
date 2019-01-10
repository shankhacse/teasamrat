<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//we need to call PHP's session object to access it through CI
class Grademaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('grademastermodel','',TRUE);
	
 }
	
 function index()
 {
   
   if($this->session->userdata('logged_in'))
   {
     /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->grademastermodel->gradelist();
	 $page = 'grade_master/list_view';
	 $header = 'grade_master/header_view';
	 
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
 
 	function add()
 	{
		 $value['grade'] = $this->input->post('grade');
		
		
		
		 if (isset($_POST))
		 {
			$id =  $this->grademastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		  $value['grade'] = $this->input->post('grade');
		 $value['id'] = $this->input->post('id');
		
		
		 if (isset($_POST))
		 {
			$this->grademastermodel->modify($value);
		}
	 
	}
	
	function delete()
	{
		$value = $this->input->post('id');
		$this->grademastermodel->delete($value);
	}
}

?>