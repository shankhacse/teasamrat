<?php

//we need to call PHP's session object to access it through CI
class voucherlist extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('voucherlistmodel', '', TRUE);
		$this->load->model('trialbalancedetailmodel', '', TRUE);
        $this->load->model('generalledgermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        }

    public function index() {

        if ($this->session->userdata('logged_in')) {

            $session = sessiondata_method();
           
            
           /* $cmpny = $session['company'];
            $year = $session['yearid'];
            
            $fromdate ="";
            $todate="";
            $purchasetype="";
            
            $vdata = array();
          
            
            
             $fromdate = $this->input->post('fromdate');
             $todate = $this->input->post('todate');
             $purchasetype = $this->input->post('purchasetype');
               
             $vdata['from_date']= date("Y-m-d",strtotime($fromdate));
             $vdata['to_date']= date("Y-m-d",strtotime($todate));
             $vdata['ptype']=$purchasetype;
             
             
           
         //   $result['voucherlist']=$this->voucherlistmodel->getVoucherList($vdata);*/
           // $result='';
		   
            $company = $session['company'];
            $yearid = $session['yearid'];
           
           
            $headercontent='';
			
			$fiscalStartDt = $this->trialbalancedetailmodel->getFiscalStartDt($yearid);
			$result['fiscalStartDt'] = $fiscalStartDt;
			$result['accountList'] =  $this->generalledgermodel->getAccountList($company,$yearid);

            $page = 'voucher_list/header_view';
            $header = '';
			
			
			
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }

    public function showvoucherList()
    {
            $fromdate = $this->input->post('fromdate');
            $todate = $this->input->post('todate');
            $purchasetype = $this->input->post('purchasetype');
            $account = $this->input->post('account');
             
            $vdata['from_date']= date("Y-m-d",strtotime($fromdate));
            $vdata['to_date']= date("Y-m-d",strtotime($todate));
            $vdata['ptype']=$purchasetype;
            $vdata['accid']=$account;

             
            $data['voucherlist']=$this->voucherlistmodel->getVoucherList($vdata);
            $page = 'voucher_list/list_view';
            $view = $this->load->view($page, $data, TRUE);
            echo($view);
        
    }

    public function getvoucherRegister(){
        
         $session =  sessiondata_method();
         if ($this->session->userdata('logged_in')) {
          
        $companyId = $session['company'];
        $yearid = $session['yearid'];
    
          
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        ini_set('memory_limit', '512M'); 
          
        $fromdate = $this->input->post('fromdate');
        $todate = $this->input->post('todate');
        $purchasetype = $this->input->post('purchasetype');
        $account = $this->input->post('account');

        
        $fiscalStartDt = $this->generalledgermodel->getFiscalStartDt($yearid);
        $result['accountname']=  $this->generalledgermodel->getAccountnameById($account);
        $result['accounting_period']=$this->generalledgermodel->getAccountingPeriod($yearid);
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);

      

        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        $result['fromDate'] = $fromdate;
        $result['toDate'] = $todate;
        $result['transtype'] = $this->getTransType($purchasetype);

        $vdata['from_date']= date("Y-m-d",strtotime($fromdate));
        $vdata['to_date']= date("Y-m-d",strtotime($todate));
        $vdata['ptype']=$purchasetype;
        $vdata['accid']=$account;

        $result['voucherlist']=$this->voucherlistmodel->getVoucherList($vdata);

          $page = 'voucher_list/voucher_register.php';
          $html = $this->load->view($page, $result, TRUE);
          $pdf->WriteHTML($html); 
          $output = 'voucherregister' . date('Y_m_d_H_i_s') . '_.pdf'; 
          $pdf->Output("$output", 'I');
                exit();
         
          } else {
            redirect('login', 'refresh');
        }
     
        
    }

    public function getTransType($trantype)
    {
        $transactionType="";
        if($trantype=="PUR")
        {
            $transactionType ="Purchase";
        }
        elseif($trantype=="SALE")
        {
            $transactionType ="Sale";
        }
        elseif($trantype=="RC")
        {
            $transactionType ="Receipt";
        }
        elseif($trantype=="PY")
        {
            $transactionType ="Payment";
        }
        elseif($trantype=="GV")
        {
            $transactionType ="General";
        }
        elseif($trantype=="JV")
        {
            $transactionType ="Journal";
        }
        elseif($trantype=="CADV")
        {
            $transactionType ="Cutsomer Advance";
        }
        elseif($trantype=="VADV")
        {
            $transactionType ="Vendor Advance";
        } 
        elseif($trantype=="CN")
        {
            $transactionType ="Contra";
        }
        elseif($trantype=="All")
        {
            $transactionType ="";
        }

        return $transactionType;
    }

        
       
 
}
?>