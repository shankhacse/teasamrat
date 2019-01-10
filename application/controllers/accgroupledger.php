<?php

//we need to call PHP's session object to access it through CI
class accgroupledger extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('trialbalancemodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
    $this->load->model('trialbalancedetailmodel', '', TRUE);
    $this->load->model('groupwiseledgermodel', '', TRUE);
		$this->load->model('groupmastermodel', '', TRUE);
        
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            $result='';
            $headercontent='';
			
      			$yearid = $session['yearid'];
            $fiscalStartDt = $this->trialbalancedetailmodel->getFiscalStartDt($yearid);
      			$result['grouplist'] = $this->groupmastermodel->groupmasterlist();
           // print_r($result['grouplist']);
      			$result['fiscalStartDt'] = $fiscalStartDt;
			       
            $page = 'groupwise_ledger/header_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }

   
    
  public function pdfGroupWiseledger(){
        
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
        $group = $this->input->post('group');
        
        $fiscalStartDt = $this->trialbalancemodel->getFiscalStartDt($yearid);
     
     
        $groupInfo  = $this->groupmastermodel->getGroupnameById($group);
        $result['groupInfo'] = $groupInfo;
       // print_r($result['groupInfo']);exit;
        
        
        $result['trialbalance']= $this->groupwiseledgermodel->getGroupWiseLedgerData($companyId,$yearid,$group,$frmDate,$toDate,$fiscalStartDt);
        $this->db->freeDBResource($this->db->conn_id); 
        
       /* echo "<pre>";
        print_r($result['trialbalance']);
        echo "</pre>";
        exit; */
       
         
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['fromDate'] = $fromdate;
        $result['toDate'] = $todate;
        
         
        
        
         
          $page = 'groupwise_ledger/group_wise_ledger_pdf.php';
          $html = $this->load->view($page, $result, TRUE);
                // render the view into HTML
                //$html="Hello";
          $pdf->WriteHTML($html); 
          $output = 'groupwiseledger' . date('Y_m_d_H_i_s') . '_.pdf'; 
          $pdf->Output("$output", 'I');
                exit();
         
          } else {
            redirect('login', 'refresh');
        }
            
    }

        
       
 
}
?>