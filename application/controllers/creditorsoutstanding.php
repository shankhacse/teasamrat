<?php

//we need to call PHP's session object to access it through CI
class creditorsoutstanding extends CI_Controller {
    
     function __construct() {
        parent::__construct();
			$this->load->model('creditorsoutstandingmodel', '', TRUE);
			$this->load->model('companymodel', '', TRUE);
			$this->load->model('trialbalancedetailmodel', '', TRUE);
      $this->load->model('vendormastermodel', '', TRUE);
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
            $result['vendor'] = $this->vendormastermodel->vendorlist($session);
			      $result['fiscalStartDt'] = $fiscalStartDt;
            $headercontent='';
            $page = 'creditors_outstanding/header_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    public function pdfCreditorsOutstanding(){
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
        $vendor = $this->input->post('drp_vendor');
        $in_vendor = "";
      
        
        if (!empty($vendor)) {
//echo "not empty";
              for($i=0;$i<sizeof($vendor);$i++)
              { 
                $in_vendor.= $vendor[$i];
                $in_vendor.=",";
              }
           
              //echo $in_vendor;
            $in_vendor = rtrim($in_vendor,',');
        }
          

           if (empty($in_vendor)) {
           // echo "empty";
            $vendorlt=$this->vendormastermodel->vendorlist($session);

            foreach ($vendorlt as $vendorlt) {
              $in_vendor.= $vendorlt->amid;
                $in_vendor.=",";
            }
            $in_vendor = rtrim($in_vendor,',');
            
          }
        
          // echo "<br>".$in_vendor;

     
        if ($detail=='C') {

              $result['accounting_period']=$this->creditorsoutstandingmodel->getAccountingPeriod($yearid);
              $result['creditorsoutstanding']= $this->creditorsoutstandingmodel->getCreditorOutstandingList($yearid,$companyId,$in_vendor,$frmDate,$toDate);
              $this->db->freeDBResource($this->db->conn_id); 
           
             
              $result['company']=  $this->companymodel->getCompanyNameById($companyId);
              $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
              $result['fromDate'] = $fromdate;
              $result['toDate'] = $todate;
              
              $page = 'creditors_outstanding/creditors_outstanding_pdf.php';
         
        }else{
          //echo "d";
             $result['accounting_period']=$this->creditorsoutstandingmodel->getAccountingPeriod($yearid);
             $result['creditorsoutstanding']= $this->creditorsoutstandingmodel->getCreditorOutstandingDetail($frmDate,$toDate,$in_vendor,$companyId,$yearid);
              $this->db->freeDBResource($this->db->conn_id); 
              $result['company']=  $this->companymodel->getCompanyNameById($companyId);
              $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
              $result['fromDate'] = $fromdate;
              $result['toDate'] = $todate;

          /*     echo "<pre>";
        print_r($result['creditorsoutstanding']);
        echo "</pre>";
        exit;*/
        
              $page = 'creditors_outstanding/creditors_outstanding_details_pdf.php';

         
        }
       



          $html = $this->load->view($page, $result, TRUE);
                // render the view into HTML
                //$html="Hello";
          $pdf->WriteHTML($html); 
          $output = 'creditoroutstanding' . date('Y_m_d_H_i_s') . '_.pdf'; 
          $pdf->Output("$output", 'I');
                exit();
         
          } else {
            redirect('login', 'refresh');
        }
    }
 
}

?>