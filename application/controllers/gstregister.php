<?php

//we need to call PHP's session object to access it through CI
class gstregister extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('gstregistermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
		ini_set('max_execution_time', 900);
    }

    public function index() {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
       

        

        if ($this->session->userdata('logged_in')) 
        {

        $headercontent = '';
        $page = 'gst_register/header_view';
        $header = '';
        /* load helper class to create view */
        createbody_method($result="", $page, $header, $session, $headercontent);

           
        } 
        else {
            redirect('login', 'refresh');
        }


       
    }

    /*
     * @date 10.01.2019
     * @author shankha
     */
     public function gstoutput() {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
       

        

        if ($this->session->userdata('logged_in')) 
        {

        $headercontent = '';
        $page = 'gst_register/header_view_gst_output';
        $header = '';
        /* load helper class to create view */
        createbody_method($result="", $page, $header, $session, $headercontent);

           
        } 
        else {
            redirect('login', 'refresh');
        }


       
    }
    
   
    
    public function getGSTRegister()
    {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) 
        {
			ini_set('max_execution_time', 900);
        
         $fromdt = date('Y-m-d',strtotime($this->input->post('fdate'))); 
         $todt = date('Y-m-d',strtotime($this->input->post('tdate'))); 
        
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
         $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
        
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        
      
        
        $result['dateRange'] =date('d-m-Y',  strtotime($fromdt)). " to ".date($todt);
        $result['printDate']=date('d-m-Y');
    
        $result['gstRegisterData']=$this->gstregistermodel->getGSTRegister($fromdt,$todt,'I',$companyId,$yearId); // I = Input

          
      
        
     /*   echo '<pre>';
        print_r($result['gstRegisterData']);
        echo '<pre>';
        
        exit;*/

        $page = 'gst_register/gst_register_inputPDF.php';
        $html = $this->load->view($page, $result, TRUE);
            
        $pdf->WriteHTML($html);
        $output = 'stockWithTransporter' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
        exit();
        } else {
            redirect('login', 'refresh');
        }
        
    }


     /*
     * @date 10.01.2019
     * @author shankha
     */


    public function getGSTRegisterOutput()
    {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) 
        {
            ini_set('max_execution_time', 900);
        
         $fromdt = date('Y-m-d',strtotime($this->input->post('fdate'))); 
         $todt = date('Y-m-d',strtotime($this->input->post('tdate'))); 
        
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
         $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
        
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        
      
        
        $result['dateRange'] =date('d-m-Y',  strtotime($fromdt)). " to ".date($todt);
        $result['printDate']=date('d-m-Y');
    
        $result['gstRegisterData']=$this->gstregistermodel->getGSTRegisterOutput($fromdt,$todt,'O',$companyId,$yearId); // O = Output

         
      
        
     /* echo '<pre>';
        print_r($result['gstRegisterData']);
        echo '<pre>';
        
        exit;*/

        $page = 'gst_register/gst_register_outputPDF.php';
        $html = $this->load->view($page, $result, TRUE);
            
        $pdf->WriteHTML($html);
        $output = 'stockWithTransporter' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
        exit();
        } else {
            redirect('login', 'refresh');
        }
        
    }

    
}//end of class