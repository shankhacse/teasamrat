<?php

//we need to call PHP's session object to access it through CI
class debitoroutstanding extends CI_Controller {
    
     function __construct() {
        parent::__construct();
			$this->load->model('debitoroutstandingmodel', '', TRUE);
			$this->load->model('companymodel', '', TRUE);
			$this->load->model('trialbalancedetailmodel', '', TRUE);
      $this->load->model('gsttaxinvoicemodel', '', TRUE);
        }
        
         public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            $company=$session['company'];
            $yearid=$session['yearid'];
          //  $result['accountList'] =  $this->debitoroutstandingmodel->getAccountList($company,$yearid);
            
          /*  echo "<pre>";
            print_r($result['accountList']);
            echo "</pre>"; */
            
			$fiscalStartDt = $this->trialbalancedetailmodel->getFiscalStartDt($yearid);
			$result['fiscalStartDt'] = $fiscalStartDt;
      $result['customer'] = $this->gsttaxinvoicemodel->getCustomerList();

     
			$headercontent='';
            $page = 'debitor_outstanding/header_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    public function pdfDebitorsOutstanding(){
         $session =  sessiondata_method();
         if ($this->session->userdata('logged_in')) {
          
          $companyId = $session['company'];
          $yearid = $session['yearid'];
    
          
         $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
          
          
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
       
        $frmDate = date("Y-m-d",strtotime($fromdate));
        $toDate = date("Y-m-d",strtotime($todate));
        $detail = $this->input->post('detail');
        $customer = $this->input->post('drp_customer');
        $in_customer = "";

          if (!empty($customer)) {
       //echo "not empty";
              for($i=0;$i<sizeof($customer);$i++)
              { 
                $in_customer.= $customer[$i];
                $in_customer.=",";
              }
           
              //echo $in_customer;
            $in_customer = rtrim($in_customer,',');
        }
       
         
           if (empty($customer)) {
           
            $customerlt=$this->gsttaxinvoicemodel->getCustomerList();

            foreach ($customerlt as $customerlt) {
              $in_customer.= $customerlt['customeracid'];
                $in_customer.=",";
            }
            $in_customer = rtrim($in_customer,',');
            
          }

//echo "<br>".$in_customer;
     
    
        if ($detail=='C') {
     // echo "c";
        $result['accounting_period']=$this->debitoroutstandingmodel->getAccountingPeriod($yearid);
        $result['debitoroutstanding']= $this->debitoroutstandingmodel->getDebitorOutstandingList($yearid,$companyId,$in_customer,$frmDate,$toDate);
        $this->db->freeDBResource($this->db->conn_id); 
       /* 
        echo "<pre>";
        print_r($result['debitoroutstanding']);
        echo "</pre>";
        exit;
        * 
        */
       
       
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['fromDate'] = $fromdate;
        $result['toDate'] = $todate;
      
         
          $page = 'debitor_outstanding/debitor_outstanding_pdf.php';

           }else{
         
       //  echo "d";



          $result['accounting_period']=$this->debitoroutstandingmodel->getAccountingPeriod($yearid);
        $result['debitoroutstanding']= $this->debitoroutstandingmodel->getDebitorOutstandingDetail($yearid,$companyId,$frmDate,$toDate,$in_customer);
        $this->db->freeDBResource($this->db->conn_id); 
      
        /*echo "<pre>";
        print_r($result['debitoroutstanding']);
        echo "</pre>";
        exit;*/
        
       
       
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['fromDate'] = $fromdate;
        $result['toDate'] = $todate;
      
         
          $page = 'debitor_outstanding/debitor_outstanding_details_pdf.php';


       }


          $html = $this->load->view($page, $result, TRUE);
                // render the view into HTML
                //$html="Hello";
          $pdf->WriteHTML($html); 
          $output = 'debitoroutstanding' . date('Y_m_d_H_i_s') . '_.pdf'; 
          $pdf->Output("$output", 'I');
                exit();
         
          } else {
            redirect('login', 'refresh');
        }
     
        
    
        
        
    }
 
}

?>