<?php

//we need to call PHP's session object to access it through CI
class profitloss extends CI_Controller {

    function __construct() {
        parent::__construct();
		
        $this->load->model('profitlossmodel', '', TRUE);
        $this->load->model('trialbalancedetailmodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        
 }

    public function index() {

        if ($this->session->userdata('logged_in')) {

		
            $session = sessiondata_method();
			 $yearid = $session['yearid'];
            $result='';
            $headercontent='';
            $page = 'profit_loss/header_view';
            $header = '';
			$fiscalStartDt = $this->trialbalancedetailmodel->getFiscalStartDt($yearid);
			$result['fiscalStartDt'] = $fiscalStartDt;
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }

  
    
  public function pdfProfitLoss()
  {
        
		$session =  sessiondata_method();
        if($this->session->userdata('logged_in')) 
		{
          
          $companyId = $session['company'];
          $yearid = $session['yearid'];
    
          
         $this->load->library('pdf');
         $pdf = $this->pdf->load();
         ini_set('memory_limit', '256M'); 
          
          
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $frmDate = date("Y-m-d",strtotime($fromdate));
        $toDate = date("Y-m-d",strtotime($todate));
        
        $fiscalStartDt = $this->trialbalancedetailmodel->getFiscalStartDt($yearid);
        
     
     
        
        
        $result['accounting_period']=$this->trialbalancedetailmodel->getAccountingPeriod($yearid);
        $result['expenditureData']= $this->profitlossmodel->getExpenditureData($companyId,$yearid,$fiscalStartDt,$toDate,$frmDate);
		$this->db->freeDBResource($this->db->conn_id); 
        $result['incomeData']= $this->profitlossmodel->getIncomeData($companyId,$yearid,$fiscalStartDt,$toDate,$frmDate);
		$this->db->freeDBResource($this->db->conn_id); 
		
			
		// Summation of expenditure and income
		$result['expenditureSum'] =  $this->findGroupBySum($result['expenditureData'],'GroupDescription','Expenditure');
		$result['incomeSum'] =  $this->findGroupBySum($result['incomeData'],'GroupDescription','Income');
		

     
       
         
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['fromDate'] = $fromdate;
        $result['toDate'] = $todate;
		
		$acc_start_dt = date('d-m-Y',strtotime($result['accounting_period']['start_date']));
		$acc_end_dt =  date('d-m-Y',strtotime($result['accounting_period']['end_date']));
		
		
		$result['profitLossHeader'] = $this->getProfitLossHeader(date('d-m-Y',strtotime($fiscalStartDt)),date('d-m-Y',strtotime($toDate)),$acc_start_dt,$acc_end_dt,$result['company'],$result['companylocation']);
        
        
		 
		
	
		

		
		
        
         
          $page = 'profit_loss/profit_losst_pdf_view.php';
        //  $html = $this->load->view($page, $result);
         $html = $this->load->view($page, $result, TRUE);
                // render the view into HTML
                //$html="Hello";
         $pdf->WriteHTML($html); 
         $output = 'profitloss' . date('Y_m_d_H_i_s') . '_.pdf'; 
         $pdf->Output("$output", 'I');
         exit();
         
          } else {
            redirect('login', 'refresh');
        }
            
    }
	
	
	public function getProfitLossHeader($frmDt,$toDt,$acc_start,$acc_end,$company,$companylocation)
	{
		$header = "";
	/* 	$header.= '</table>';
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
	
	
	function findGroupBySum(array $input ,$keysearch,$val){ 
			 $summedArray = array();
				foreach ($input as $key => $value) {
					$summedArray[$value[$keysearch]] += $value[$val];
				}
			return $summedArray;
		}

        
       
 
}
?>