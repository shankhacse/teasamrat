<?php

//we need to call PHP's session object to access it through CI
class generalledgerreport extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('generalledgermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
		$this->load->model('trialbalancedetailmodel', '', TRUE);
        
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            $company=$session['company'];
            $yearid=$session['yearid'];
            $result['accountList'] =  $this->generalledgermodel->getAccountList($company,$yearid);
            
      			$fiscalStartDt = $this->trialbalancedetailmodel->getFiscalStartDt($yearid);
      			$result['fiscalStartDt'] = $fiscalStartDt;
			
          /*  echo "<pre>";
            print_r($result['accountList']);
            echo "</pre>"; */
            
            $headercontent='';
            $page = 'general_ledger_report/header_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }
	
	public function type2() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            $company=$session['company'];
            $yearid=$session['yearid'];
            $result['accountList'] =  $this->generalledgermodel->getAccountList($company,$yearid);
            
      			$fiscalStartDt = $this->trialbalancedetailmodel->getFiscalStartDt($yearid);
      			$result['fiscalStartDt'] = $fiscalStartDt;
			
          /*  echo "<pre>";
            print_r($result['accountList']);
            echo "</pre>"; */
            
            $headercontent='';
            $page = 'general_ledger_report/header_view2';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }
    
    
    public function pdfGeneralLedger(){
        
         $session =  sessiondata_method();
         if ($this->session->userdata('logged_in')) {
          
		  ini_set('max_execution_time', 600);
		  
		  
		  
          $companyId = $session['company'];
          $yearid = $session['yearid'];
    
          
         $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
          
          
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $accId = $this->input->post('account');
         /* $reportType = $this->input->post('reportType');*/ /* change done by shankha recomended by abhik 10.01.2019*/
        $reportType = 'TYPE3';
		
        $frmDate = date("Y-m-d",strtotime($fromdate));
        $toDate = date("Y-m-d",strtotime($todate));
        
        $fiscalStartDt = $this->generalledgermodel->getFiscalStartDt($yearid);
        
     
     
        
        $result['accountname']=  $this->generalledgermodel->getAccountnameById($accId);
        $result['accounting_period']=$this->generalledgermodel->getAccountingPeriod($yearid);
		$result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['fromDate'] = $fromdate;
        $result['toDate'] = $todate;
		
		
		if($reportType=="TYPE1")
		{
			$result['generalledger']= $this->generalledgermodel->getGeneralLedgerReport($companyId,$yearid,$accId,$frmDate,$toDate,$fiscalStartDt);
			$this->db->freeDBResource($this->db->conn_id); 
			$page = 'general_ledger_report/general_ledger_pdf.php';
		}
		if($reportType=="TYPE2")
		{
			$result['generalledger']= $this->generalledgermodel->getGeneralLedgerReportType2($companyId,$yearid,$accId,$frmDate,$toDate,$fiscalStartDt);
			$this->db->freeDBResource($this->db->conn_id); 
			$page = 'general_ledger_report/general_ledger_pdf_type2.php';
		}
        
        if($reportType=="TYPE3")
        {
            $result['generalledger']= $this->generalledgermodel->getGeneralLedgerReportType3($frmDate,$toDate,$companyId,$yearid,$accId,$fiscalStartDt);
            $this->db->freeDBResource($this->db->conn_id);
            $page = 'general_ledger_report/general_ledger_pdf_type3.php';
        }
		
        //$html = $this->load->view($page, $result);
		
		
		
        $html = $this->load->view($page, $result, TRUE);
        $pdf->WriteHTML($html); 
        $output = 'generalledger' . date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdf->Output("$output", 'I');
        exit();
       
          } else {
            redirect('login', 'refresh');
        }
     
        
    }
	
	
	public function pdfGeneralLedgerType2()
	{
        
         $session =  sessiondata_method();
         if ($this->session->userdata('logged_in')) {
          
          $companyId = $session['company'];
          $yearid = $session['yearid'];
    
          
         $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
          
          
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $accId = $this->input->post('account');
        $reportType = $this->input->post('reportType');
		
        $frmDate = date("Y-m-d",strtotime($fromdate));
        $toDate = date("Y-m-d",strtotime($todate));
        
        $fiscalStartDt = $this->generalledgermodel->getFiscalStartDt($yearid);
        
     
     
        
        $result['accountname']=  $this->generalledgermodel->getAccountnameById($accId);
        $result['accounting_period']=$this->generalledgermodel->getAccountingPeriod($yearid);
		$result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['fromDate'] = $fromdate;
        $result['toDate'] = $todate;
		
		if($reportType=="TYPE1")
		{
			$result['generalledger']= $this->generalledgermodel->getGeneralLedgerReport($companyId,$yearid,$accId,$frmDate,$toDate,$fiscalStartDt);
			$this->db->freeDBResource($this->db->conn_id); 
			$page = 'general_ledger_report/general_ledger_pdf.php';
		}
		if($reportType=="TYPE2")
		{
			$result['generalledger']= $this->generalledgermodel->getGeneralLedgerReportType2($companyId,$yearid,$accId,$frmDate,$toDate,$fiscalStartDt);
			$this->db->freeDBResource($this->db->conn_id); 
			$page = 'general_ledger_report/general_ledger_pdf_type2.php';
			
		
        }
        if($reportType=="TYPE3")
        {
            //CALL `usp_generalLedgerStyle3`('2018-04-01','2019-03-31',3,8,896,'2018-04-01');
            //`usp_generalLedgerStyle3`(fromdate DATE,todate DATE,companyid INT,yearid INT,accountid INT,fiscalStartDate DATE)
            
            $result['generalledger']= $this->generalledgermodel->getGeneralLedgerReportType3($frmDate,$toDate,$companyId,$yearid,$accId,$fiscalStartDt);
            $this->db->freeDBResource($this->db->conn_id);
            $page = 'general_ledger_report/general_ledger_pdf_type3.php';

        }
		
		
        //$html = $this->load->view($page, $result);
		
		
        $html = $this->load->view($page, $result, TRUE);
        $pdf->WriteHTML($html); 
        $output = 'generalledger' . date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdf->Output("$output", 'I');
        exit();
       
          } else {
            redirect('login', 'refresh');
        }
     
        
    }
    
}
?>