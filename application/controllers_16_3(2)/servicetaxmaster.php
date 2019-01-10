<?php 
//we need to call PHP's session object to access it through CI
class Servicetaxmaster extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('servicetaxmastermodel','',TRUE);
	
 }
	
 function index()
 {
   
   if($this->session->userdata('logged_in'))
   {
     /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
	 
	/*get the detail of the page body*/
	 $result = $this->servicetaxmastermodel->servicetaxlist();
	 $page = 'servicetax_master/list_view';
	 $header = 'servicetax_master/header_view';
	 
	/*load helper class to create view*/
	//$this->load->helper('createbody_helper');
	createbody_method($result,$page,$header,$session);
		
 	}
	else
   {
     redirect('login', 'refresh');
   }
 }
 
 	function add()
 	{
		 $value['tax_rate'] = $this->input->post('rate');
		 $value['from_date'] = date("Y-m-d", strtotime($this->input->post('from')));
		 $value['to_date'] = date("Y-m-d", strtotime($this->input->post('to')));
		
		 if (isset($_POST))
		 {
			$id =  $this->servicetaxmastermodel->add($value);
			echo $id;
      		
		 }
	 
	}
	
 	function modify()
 	{
		 $value['tax_rate'] = $this->input->post('rate');
		 $value['from_date'] =  date("Y-m-d", strtotime($this->input->post('from')));
		 $value['to_date'] = date("Y-m-d", strtotime($this->input->post('to')));
		 $value['id'] = $this->input->post('id');
		
		
		 if (isset($_POST))
		 {
			$this->servicetaxmastermodel->modify($value);
			
      		
		 }
	 
	}
	
	function delete()
	{
		$value = $this->input->post('id');
		$this->servicetaxmastermodel->delete($value);
	}
}

?>