<?php

//we need to call PHP's session object to access it through CI
class bankreconciliation extends CI_Controller {
    
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
            $page = 'bank_reconcilation/header_view';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        
           
        } else {
            redirect('login', 'refresh');
        }
    }
    
    

    public function getBankReconcilationList()
    {
        if ($this->session->userdata('logged_in')) 
        {
          $session = sessiondata_method();
          $company = $session['company'];
          $yearid = $session['yearid'];
          $bankAccID = $this->input->post('bankAccID');
          $frmDt = date('Y-m-d',strtotime($this->input->post('frmDt')));
          $toDt = date('Y-m-d',strtotime($this->input->post('toDt')));
          
           
          $data['BankReconcilationList'] = $this->bankreconcilationmodel->getBankReconcilationList($bankAccID,$frmDt,$toDt,$company,$yearid);
          $data['BankReconcilationOP'] = $this->bankreconcilationmodel->getOpeningBalanceBankReconciliation($bankAccID,$yearid,$company,$frmDt,$toDt);
          $this->db->freeDBResource($this->db->conn_id); 

         

          $page = 'bank_reconcilation/list_view';
          $view = $this->load->view($page, $data , TRUE );
          echo($view);
      }
      else
      {
         redirect('login', 'refresh');
      }

    }

    public function updateChequeInfo()
    {
         if ($this->session->userdata('logged_in')) 
          {
            $session = sessiondata_method();
            $company = $session['company'];
            $yearid = $session['yearid'];


            $bankAccID = trim($this->input->post('accid'));
            $frmDt = date('Y-m-d',strtotime($this->input->post('fadte')));
            $toDt =  date('Y-m-d',strtotime($this->input->post('tdate')));


            $vmid = $this->input->post('vmid');
            $clearDt = trim($this->input->post('clearDt'));
            $clear_date = str_replace('/', '-', $clearDt);
            $upd_data = array(
              "chq_clear_on" => date('Y-m-d',strtotime($clear_date)),
              "is_chq_clear" => 'Y',
            );
            
            $update = $this->bankreconcilationmodel->updateChequeInfo($vmid,$upd_data);

            if($update)
            {
              $BankReconcilationOP = $this->bankreconcilationmodel->getOpeningBalanceBankReconciliation($bankAccID,$yearid,$company,$frmDt,$toDt);
              $this->db->freeDBResource($this->db->conn_id); 

              $json_response = array(
                "msg_status" => 1,
                "msg_data" => "updated successfully",
                "opBalance" => $BankReconcilationOP['openingBalance'],
                "closingBalance" => $BankReconcilationOP['closingBalance']
              );
            }
            else
            {
              $json_response = array(
                "msg_status" => 0,
                "msg_data" => "There is some problem while updating ...Please try again."
              );
            }

            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit;
        }
        else
        {
           redirect('login', 'refresh');
        }
    }

    public function cancelChequeInfo()
    {
      if ($this->session->userdata('logged_in')) 
          {
            $session = sessiondata_method();
            $company = $session['company'];
            $yearid = $session['yearid'];


            $bankAccID = trim($this->input->post('accid'));
            $frmDt = date('Y-m-d',strtotime($this->input->post('fadte')));
            $toDt =  date('Y-m-d',strtotime($this->input->post('tdate')));
            $vmid = $this->input->post('vmid');
            $upd_data = array(
              "chq_clear_on" => NULL,
              "is_chq_clear" => 'N'
            );
            
            $update = $this->bankreconcilationmodel->updateChequeInfo($vmid,$upd_data);

            if($update)
            {
              $BankReconcilationOP = $this->bankreconcilationmodel->getOpeningBalanceBankReconciliation($bankAccID,$yearid,$company,$frmDt,$toDt);
              $this->db->freeDBResource($this->db->conn_id); 

              $json_response = array(
                "msg_status" => 1,
                "msg_data" => "updated successfully",
                "opBalance" => $BankReconcilationOP['openingBalance'],
                "closingBalance" => $BankReconcilationOP['closingBalance']
              );
            }
            else
            {
              $json_response = array(
                "msg_status" => 0,
                "msg_data" => "There is some problem while updating ...Please try again."
              );
            }

            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit;
        }
        else
        {
           redirect('login', 'refresh');
        }
    }




}

?>