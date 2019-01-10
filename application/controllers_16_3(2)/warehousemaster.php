<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//we need to call PHP's session object to access it through CI
class Warehousemaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('warehousemastermodel','',TRUE);
	
 }
	
 function index()
 {
   
   if($this->session->userdata('logged_in'))
   {
     /*load session data*/	
	 //$this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->warehousemastermodel->warehouselist();
	 $page = 'warehouse_master/list_view';
	 $header = 'warehouse_master/header_view';
	 
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
		 $value['code'] = $this->input->post('code');
		 $value['name'] = $this->input->post('name');
		 $value['area'] = $this->input->post('area');
		
		
		 if (isset($_POST))
		 {
			$id =  $this->warehousemastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		 $value['code'] = $this->input->post('code');
		 $value['name'] = $this->input->post('name');
		 $value['area'] = $this->input->post('area');
		 $value['id'] = $this->input->post('id');
		
		
		 if (isset($_POST))
		 {
			$this->warehousemastermodel->modify($value);
			
      		
		 }
	 
	}
	
	function delete()
	{
		$value = $this->input->post('id');
		$this->warehousemastermodel->delete($value);
	}
}

?>