<?php

//we need to call PHP's session object to access it through CI
class stocksummeryall extends CI_Controller {
    
     function __construct() {
        parent::__construct();
		$this->load->model('stocksummerymodelall', '', TRUE);
        $this->load->model('teagroupmastermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
    }
    
	public function index() {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
      
        //print_r($session);
		if ($this->session->userdata('logged_in')) {
		  $result['teagrouplist'] =  $this->teagroupmastermodel->teagrouplist();
				 
			$headercontent = '';
			$page = 'stocksummeryall/header_view';
			$header = '';
			/* load helper class to create view */
			createbody_method($result, $page, $header, $session, $headercontent);
			  }
		else {
			   redirect('login', 'refresh');   
			  }
	}
	
	
	   public function getStock(){
       $session = sessiondata_method(); 
       $companyId = $session['company'];
       $yearId = $session['yearid'];
      
       $groupId = $this->input->post('groupId');
       $fromPrice = $this->input->post('fromPrice');
       $toPrice = $this->input->post('toPrice');
       $toDate = date('Y-m-d',  strtotime($this->input->post('toDate')));
       
       $result['stock'] = $this->stocksummerymodelall->getStock($groupId,$fromPrice,$toPrice,$companyId,$toDate,$yearId);
	   $this->db->freeDBResource($this->db->conn_id); 
       $this->load->view('stocksummeryall/list_view',$result);
    
   }
   
   
    public function getStockpdf(){
        
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        ini_set('memory_limit', '256M'); 

        $companyId = $session['company'];
        $yearId = $session['yearid'];
		    $groupReport="";
       
       $groupId = $this->input->post('group_code');
       $fromPrice = $this->input->post('fromPrice');
       $toPrice = $this->input->post('toPrice');
       $toDate = date('Y-m-d',  strtotime($this->input->post('toDate')));
       
       
       $data['company']=  $this->companymodel->getCompanyNameById($companyId);
       $data['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
       $data['printDate']=date('d-m-Y');
       $data['upto']=$this->input->post('toDate');
       $data['stock']=$this->stocksummerymodelall->getStock($groupId,$fromPrice,$toPrice,$companyId,$toDate,$yearId);
	     $this->db->freeDBResource($this->db->conn_id); 
       
	  
        
          
        //$page = 'stocksummeryall/pdf_list_view';   
        $page = 'stocksummeryall/test_view';
        $html = $this->load->view($page, $data,true);
        $pdf->WriteHTML($html); 
        $output = 'stockPdfLogical' . date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdf->Output("$output", 'I');

        //echo $html;

        /*$html = $this->load->view($page, $result, true);
                // render the view into HTML
        $pdf->WriteHTML($html); 
        $output = 'stockPdf' . date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdf->Output("$output", 'I');
        exit();
        */
            
       }
        else {
           redirect('login', 'refresh');   
          }
      }
    
}
?>