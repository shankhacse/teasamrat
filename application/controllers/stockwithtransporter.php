<?php

//we need to call PHP's session object to access it through CI
class Stockwithtransporter extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('doreceivedmodel', '', TRUE);
        $this->load->model('transportmastermodel', '', TRUE);
        $this->load->model('locationmastermodel', '', TRUE);
        $this->load->model('companymodel','',TRUE);
        $this->load->model('warehousemastermodel','',TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
        echo $selected_transporter = $this->input->post('drpTransporter');

        // $ispending = $this->input->post('chkpendingdo');

        if ($this->session->userdata('logged_in')) {

             $result['transporterlist'] = $this->transportmastermodel->transportlist();
             $result['warehouselist'] = $this->warehousemastermodel->warehouselist();

            if ($selected_transporter == '') {
               
                $result['selected_transporter'] = (!$selected_transporter ? "0" : $selected_transporter);
                $result['doRcvTransList']='';
               
            } else {
                $result['doRcvTransList'] = $this->doreceivedmodel->getDoTransporter($selected_transporter);
                $result['selected_transporter'] = (!$selected_transporter ? "0" : $selected_transporter);
                $result['location']=  $this->locationmastermodel->loactionmasterlist();

             
            }
        } else {
            redirect('login', 'refresh');
        }


        $headercontent = '';
        $page = 'stock_with_transporter/header_view';
        $header = '';
        /* load helper class to create view */
        createbody_method($result, $page, $header, $session, $headercontent);
    }
    
    public function liststockwithtransporter(){
        
        $transporterId = $this->input->post('transporterid');
        $warehouseid = $this->input->post('warehouseid');

        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');

        $session = sessiondata_method();
        $company = $session['company'];
        
       // $company = $session['company'];
      //  $year = $session['yearid'];
       /* $value = array(
            
            'transporterid'=> $transporter,
      
        );*/
        
        $data['stock_with_transporter'] = $this->doreceivedmodel->getStockwithtransporter($transporterId,$company,$warehouseid,$fdate,$tdate);
        
     
        $page = 'stock_with_transporter/list_view';
        $view = $this->load->view($page, $data , TRUE );
        echo($view);
    
    }
    
    public function getStockWithTransPrint(){
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        $data['company']=  $this->companymodel->getCompanyNameById($companyId);
        $data['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        
        $data['dateRange'] =date('d-m-Y',  strtotime('01-04-2013')). " to ".date('d-m-Y');
        $data['printDate']=date('d-m-Y');
       
        $transporteridrep = $this->input->post('transporterid');
        $warehouseid = $this->input->post('warehouseid');
        $fdate = $this->input->post('fdate');
        $tdate = $this->input->post('tdate');

        $data['transporterName']=  $this->doreceivedmodel->getTransporterName($transporteridrep);
        $data['warehouseName']= "";
        if($warehouseid>0)
        {
            $data['warehouseName']=$this->warehousemastermodel->getWarehouseName($warehouseid);
        }

        $data['searchperiod']="";
        if($fdate!="" && $tdate!="")
        {
         $data['searchperiod']=date("d-m-Y",strtotime($fdate))." To ".date("d-m-Y",strtotime($tdate));
        }
        
        $data['stock_with_transporter_report'] = $this->doreceivedmodel->getStockwithtransporter($transporteridrep,$companyId,$warehouseid,$fdate,$tdate);
        // print_r($data['transporterName']);
        $page = 'stock_with_transporter/stk_with_transporter_report';
        $view = $this->load->view($page,$data, TRUE );
        echo($view);
    }
    
    public function getStockWithTransporterPdf(){
         $session = sessiondata_method();
         if ($this->session->userdata('logged_in')) {
         
        if($this->uri->segment(3)==FALSE){$transporterId = 0;}
        else{$transporterId =$this->uri->segment(3);}

        if($this->uri->segment(4)==FALSE){$warehouseid = 0;}
        else{$warehouseid =$this->uri->segment(4);}

        if($this->uri->segment(5)==FALSE){$fdate = "";}
        else{$fdate =$this->uri->segment(5);}

        if($this->uri->segment(6)==FALSE){$tdate = 0;}
        else{$tdate =$this->uri->segment(6);}
       
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
         $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
        
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        
      
        
        $result['dateRange'] =date('d-m-Y',  strtotime('01-04-2013')). " to ".date('d-m-Y');
        $result['printDate']=date('d-m-Y');
       
       // $transporteridrep = $this->input->post('transporterid');
        $result['transporterName']=$this->doreceivedmodel->getTransporterName($transporterId);

        $result['warehouseName']= "";
        if($warehouseid>0)
        {
            $result['warehouseName']=$this->warehousemastermodel->getWarehouseName($warehouseid);
        }

        $result['searchperiod']="";
        if($fdate!="" && $tdate!="")
        {
         $result['searchperiod']=date("d-m-Y",strtotime($fdate))." To ".date("d-m-Y",strtotime($tdate));
        }
        

        $result['stck_with_transprtr_pdf'] = $this->doreceivedmodel->getStockwithtransporter($transporterId,$companyId,$warehouseid,$fdate,$tdate);
        
          
       /* echo "<pre>";
            print_r($result['transporterName']);
        echo "<pre>"; */
                        
       
        
        
        
      /*  echo '<pre>';
        print_r($data['stck_with_transprtr_pdf']);
        echo '<pre>';*/
        
        $page = 'stock_with_transporter/stock_with_tranporterPdf.php';
        $html = $this->load->view($page, $result, TRUE);
            
        $pdf->WriteHTML($html);
        $output = 'stockWithTransporter' . date('Y_m_d_H_i_s') . '_.pdf';
        $pdf->Output("$output", 'I');
        exit();
        } else {
            redirect('login', 'refresh');
        }
        
    }
    
}