<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//we need to call PHP's session object to access it through CI
class Unreleaseddo extends CI_Controller {

 function __construct()
 {
   parent::__construct();
    $this->load->model('unreleaseddomodel','',TRUE);
  
	 
}
	
 function index()
 {
   
   if($this->session->userdata('logged_in'))
   {
     /*load session data*/	
	// $this->load->helper('sessiondata_helper');
	 $session = sessiondata_method();
		 
	/*get the detail of the page body*/
	
	 $headercontent ='';
	
	
	 $page = 'unreleaseddo_master/unreleaseddo_view';
	 $header = '';
	 $result = $this->session->userdata('unreleaseddo_list_invoice');//'';
	 
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
  
  function getListofinvoice()
  {
	 
	  $result = $this->unreleaseddomodel->getPurchaseinvoicelist($this->input->get('term'));
	   echo json_encode($result);
	   exit;
   }
   
   function getdodetail()
   {
	   
	   $number = $this->input->get('number');
	   $result['data'] = $this->unreleaseddomodel->dodata($number);
	   $page = 'unreleaseddo_master/dodetail_view';
	   $this->load->view($page,$result);
	  
   }
   
   function savedata()
   {
	  	$unreleaseddoidarr = $this->input->post('unreleaseddoid');
	    $donumberarr = $this->input->post('donumber');
		$dodatearr = $this->input->post('dodate');
		$dodatehidearr = $this->input->post('dodatehide');
		
		for($i= 0; $i<count($donumberarr); $i++)
		{
			if($unreleaseddoidarr[$i] != '')
			{
				$value['id'] = $unreleaseddoidarr[$i];
				$value['purchase_invoice_master_id'] = $this->input->post('masterid');
				$value['do_number'] = $donumberarr[$i];
				$value['do_date'] = date("Y-m-d", strtotime($dodatearr[$i]));
				$result = $this->unreleaseddomodel->modifydata($value);
			}
			else
			{
					 $value['purchase_invoice_master_id'] = $this->input->post('masterid');
					 $value['do_number'] = $donumberarr[$i];
					 $value['do_date'] = date("Y-m-d", strtotime($dodatearr[$i]));
				
					$result = $this->unreleaseddomodel->insertDate($value);
			}
			$this->session->set_userdata('unreleaseddo_list_invoice',$this->input->post('pinvoicenumber'));
		}
	//	header("Location: http://localhost:8080/meet2eat/index.php");
		 redirect('unreleaseddo', 'refresh');

	}
 

}

?>
