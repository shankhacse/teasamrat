<?php

//we need to call PHP's session object to access it through CI
class bankreconciliationstatement extends CI_Controller {
    
     function __construct() {
        parent::__construct();
			    $this->load->model('companymodel', '', TRUE);  
          $this->load->model('trialbalancedetailmodel', '', TRUE);
    			$this->load->model('bankreconcilationmodel', '', TRUE);
        }
        
         public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
            $company=$session['company'];
            $yearid=$session['yearid'];
            $result['bankAccountList'] =  $this->bankreconcilationmodel->getBankAc($company);
      
            
			       $fiscalStartDt = $this->trialbalancedetailmodel->getFiscalStartDt($yearid);
			       $result['fiscalStartDt'] = $fiscalStartDt;
			       $headercontent='';
            $page = 'bank_reconciliation_statement/header_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }

    public function getPdf()
    {
        
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        ini_set('memory_limit', '256M'); 

        $company = $session['company'];
        $yearid = $session['yearid'];
        $groupReport="";
       

       $fiscalStartDt = $this->trialbalancedetailmodel->getFiscalStartDt($yearid);


       $bankAccID = $this->input->post('bankAccID');
       $frmDt = date('Y-m-d',  strtotime($this->input->post('fromDt')));
       $toDt = date('Y-m-d',  strtotime($this->input->post('toDt')));

      $data['fromDate'] = date('Y-m-d',  strtotime($frmDt));
      $data['toDate'] = date('Y-m-d',  strtotime($toDt));

      $acc_start_dt = date('d-m-Y',strtotime($data['accounting_period']['start_date']));
      $acc_end_dt =  date('d-m-Y',strtotime($data['accounting_period']['end_date']));
      $data['profitLossHeader'] = $this->getProfitLossHeader(date('d-m-Y',strtotime($fiscalStartDt)),$toDt,$acc_start_dt,$acc_end_dt,$result['company'],$result['companylocation']);

       $data['company']=  $this->companymodel->getCompanyNameById($company);
       $data['companylocation']=  $this->companymodel->getCompanyAddressById($company);
       $data['printDate']=date('d-m-Y');
       $data['accounting_period']=$this->trialbalancedetailmodel->getAccountingPeriod($yearid);
       $data['AsBankBookStatement'] = $this->bankreconcilationmodel->getClosingAsBankBook($bankAccID,$yearid,$company,$frmDt,$toDt);
        $this->db->freeDBResource($this->db->conn_id); 
       $data['AddNotEncashed'] = $this->bankreconcilationmodel->getNotEncashed($bankAccID,$yearid,$company,$frmDt,$toDt,'N'); // N = Cr
       $data['MinusNotEncashed'] = $this->bankreconcilationmodel->getNotEncashed($bankAccID,$yearid,$company,$frmDt,$toDt,'Y'); // Y = Dr

        //$page = 'stocksummeryall/pdf_list_view';   
        $page = 'bank_reconciliation_statement/bank_reconciliation_pdf';
        $html = $this->load->view($page, $data,true);
        $pdf->WriteHTML($html); 
        $output = 'bankreconciliation_statement' . date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdf->Output("$output", 'I');

     
       }
        else {
           redirect('login', 'refresh');   
          }
      }



      public function getProfitLossHeader($frmDt,$toDt,$acc_start,$acc_end,$company,$companylocation)
  {
    $header = "";
  /*  $header.= '</table>';
        $header.='<div class="break"></div>';
          $header.='$ln_count = 1'; */
        $header.='<table width="100%">';
          $header.='<tr><td align="center"><b>Profit & Loss</b><br>';
          $header.='<span style="font-size:12px;">'."$frmDt".' To '."$toDt".'</span></td></tr>';
        $header.='</table>';
          
        $header.='<div style="padding:2px 0 5px 0;"></div>';
        $header.='<table width="25%" align="right">';
          $header.='<tr>';
            $header.='<td align="center"><span style="font-size:12px;"><b>Accounting Year</b><br></span></td>';
          $header.='</tr>';
          $header.='<tr>';
            $header.='<td><span style="font-size:12px;">('."$acc_start".' To '."$acc_end".')</span></td>';
          $header.='</tr>';
        $header.='</table>';
          
        $header.='<table width="100%" class="">';
            $header.='<tr>';
            $header.='<td align="left">';
              $header.='<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">'.$company;
              $header.='<br/>'.$companylocation;
              $header.='</span>';
            $header.='</td>';
          
            $header.='<td align=right>';
                $header.='<span style="font-family:Verdana, Geneva, sans-serif; font-size:12px; font-weight:bold;">';
              $header.='Print Date : &nbsp; '.date("d-m-Y");
              $header.='</span>';
            $header.='</td>';
          $header.='</tr>';
        $header.='</table>';
          
        $header.='<div style="padding:4px"></div>';
        
        $header.='<table width="100%" class="demo">';
        
        return $header;
  }
    

}

?>