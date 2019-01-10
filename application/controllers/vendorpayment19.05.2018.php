<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class vendorpayment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendormastermodel', '', TRUE);
        $this->load->model('generalvouchermodel', '', TRUE);
        $this->load->model('vendoradvancemodel', '', TRUE);
        $this->load->model('vendoradvanceadjstmodel', '', TRUE);
        $this->load->model('vendorpaymentmodel', '', TRUE);
    }

    public function index() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            $result = $this->vendorpaymentmodel->getVendorPaymentList($session['company'],$session['yearid']);
            $page = 'vendorpayment/list_view';
            $header = '';
            $headercontent = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }

    public function addVendorPayment() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {
                $vendorpaymentId = 0;
            } else {
                $vendorpaymentId = $this->uri->segment(4);
            }
            $headercontent['vendors'] = $this->vendormastermodel->getVendorList();
            $headercontent['CashOrBank'] = $this->generalvouchermodel->getAccountByGroupMaster($session['company']);

            if ($vendorpaymentId == 0) {
                $headercontent['mode'] = "Add";
                $page = 'vendorpayment/addEdit';
                $result = "";
            } else {
                 $headercontent['mode'] = "Edit";
                 $page = 'vendorpayment/addEdit';
                 $result["vendorpayment"] = $this->vendorpaymentmodel->getVendorPaymentMasterDataById($vendorpaymentId);
                 $result["vendorPaymentDtl"] = $this->vendorpaymentmodel->getVendorPaymentDetails($vendorpaymentId);
                 $result['invoices'] = $this->vendoradvanceadjstmodel->getPurchaseInvoiceByVendor($result["vendorpayment"]["vendoraccountid"]);
                 $this->db->freeDBResource($this->db->conn_id); 



            }
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }

    public function getPurchaseBillList() {
        $vendorAccountId = $this->input->post('vendoraccId');
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {

           // $result['invoices'] = $this->vendoradvanceadjstmodel->getPurchaseInvoiceByVendor($vendorAccountId); // close
            $result['invoices'] = $this->vendoradvanceadjstmodel->getPurchaseInvoiceByVendor($vendorAccountId);
            $this->db->freeDBResource($this->db->conn_id); 

            /*echo "<pre>";
            print_r($result['invoices']);
            echo "<pre>";*/


            $page = 'vendoradvanceadjust/detail.php';
            $this->load->view($page, $result);
        } else {
            redirect('login', 'refresh');
        }
    }

    public function rePopulatePurchaseBillList() 
    {
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {

            $formData = $this->input->post('formDatas');
            parse_str($formData, $dataArry);

          
            $vendorAccountId = $dataArry['vendor'];
            $notinVal ="";
            if(isset($dataArry['vendBillMasterIDS']))
            {
                for($i=0;$i<sizeof($dataArry['vendBillMasterIDS']);$i++)
                {   
                    //$notinVal.=$dataArry['investigation_code'][$i].",";
                    $notinVal.=$dataArry['vendBillMasterIDS'][$i].",";
                }
            }
          
            $result['invoices'] = $this->vendoradvanceadjstmodel->getPurchaseInvoiceByVendor($vendorAccountId,$notinVal);
            $this->db->freeDBResource($this->db->conn_id); 

            $page = 'vendoradvanceadjust/detail.php';
            $this->load->view($page, $result);
          

        } else {
            redirect('login', 'refresh');
        }
    }


    public function deleteDetailData()
    {

        $session = sessiondata_method();
        $companyId = $session['company'];
        if ($this->session->userdata('logged_in')) {

            $vendorBillMasterId = $this->input->post('vendorbillmasterID');
            

            $delete = $this->vendorpaymentmodel->deleteVendorPaymentDtl($vendorBillMasterId);
            if($delete)
            {
                 echo json_encode(array('status'=>"Deleted"));
            }
            else
            {
                 echo json_encode(array('status'=>"Error"));
            }
           
            exit();
            
            
        } else {
            redirect('login', 'refresh');
        }
    }

    public function saveVendorPayment() {
        $session = sessiondata_method();

        if ($this->session->userdata('logged_in')) {
            $masterData["vendorPaymentId"] = $this->input->post("vendorPaymentId");
            $masterData["voucherId"]=  $this->input->post("voucherId");
            $masterData["dateofpayment"] = $this->input->post("paymentDate");
            $masterData["transaction_type"] = 'PY';
            $masterData["creditAccountId"] = $this->input->post("creditAccountId");
            $masterData["chequeNo"] = $this->input->post("chequeNo");
            $masterData["chequeDate"] = $this->input->post("chequeDate");
            $masterData["vendorId"] = $this->input->post("vendorId");
            $masterData["totalPayment"] = $this->input->post("totalPayment");
            $masterData["narration"]= $this->input->post("narration");
            
            if($masterData["vendorPaymentId"]==0){
                    $masterData["voucherNumber"] = $this->getvouchernumber();
                    $masterData["voucherSerial"] = $this->generate_serial_no();
                    $masterData["lastSrNo"] = $this->getSerialNumber();
            }
            
            $masterData["companyId"] = $session['company'];
            $masterData["yearId"] = $session["yearid"];
            $masterData["userId"]=$session["user_id"];

            $details = $this->input->post('details');
                     
            $billDetails;
           
            foreach ($details as $value) {
               
                foreach ($value as $data) {

                    $billDetails[] = array(
                        'vendorBillMasterId' => $data['vendorBillMasterId'],
                        'paidAmount' => $data['paidAmount']
                    );

                    
                }
            }



            
            if ($masterData["vendorPaymentId"] == 0) {
               $result =  $this->vendorpaymentmodel->insertData($masterData, $billDetails);
               $this->output->set_content_type('application/json')
                            ->set_output(json_encode($result));
              
            } else {
               $result =  $this->vendorpaymentmodel->UpdateData($masterData, $billDetails);
               $this->output->set_content_type('application/json')
                            ->set_output(json_encode($result));
            }
        } else {

            redirect('login', 'refresh');
        }
    }
    
    
     public function getUnpaidBillAmount(){
        
        $vendorBillMasterId = $this->input->post('vendorBillMasterId');
        $vendorPaymentId = $this->input->post('vendorPaymentId');
        $session = sessiondata_method();
        $companyId = $session['company'];
       
        
         if ($this->session->userdata('logged_in')) {

            $unpaidAmount = $this->vendorpaymentmodel->getVendorUnpaidBill($vendorBillMasterId,$companyId,$vendorPaymentId);
            echo json_encode(array('unpaidAmt'=>$unpaidAmount));
            exit();
            
            
        } else {
            redirect('login', 'refresh');
        }
    }
    

    public function getvouchernumber() {
        $session = sessiondata_method();
        $cid = $session['company'];
        $yid = $session['yearid'];
        $voucher_srl_no = $this->generalvouchermodel->getSerailvoucherNo($cid, $yid);
        $srl = intval($voucher_srl_no) + 1;
        $padding = '00000';
        if ($srl >= 10 && $srl < 100) {
            $padding = '00000';
        } elseif ($srl >= 100 && $srl < 1000) {
            $padding = '000';
        } elseif ($srl >= 1000 && $srl < 10000) {
            $padding = '00';
        } elseif ($srl >= 10000 && $srl < 10000) {
            $padding = '0';
        } elseif ($srl >= 100000 && $srl < 1000000) {
            $padding = '';
        }
        $voucherNo = $padding . $srl . "/" . substr($session['startyear'], 2, 2) . "-" . substr($session['endyear'], 2, 2);

        //echo "serial No is".$srl;
        return $voucherNo;
    }

    public function getSerialNumber() {

        $session = sessiondata_method();
        $cid = $session['company'];
        $yid = $session['yearid'];
        $voucher_srl_no = $this->generalvouchermodel->getSerailvoucherNo($cid, $yid);
        $srl = $voucher_srl_no + 1;
        return $srl;
    }

    private function generate_serial_no() {
        $session = sessiondata_method();
        $cid = $session['company'];
        $yid = $session['yearid'];
        $voucher_srl_no = $this->generalvouchermodel->getLastSerialNo($cid, $yid);
        $srl = $voucher_srl_no['serialNo'] + 1;
        //echo "serial No is".$srl;
        return $srl;
    }
    
    
    public function getDetailsOfInvoice(){
        $session = sessiondata_method();
        $paymentId = $this->input->post('vendorpaymentId');

        if ($this->session->userdata('logged_in')) {
            
            $result['invoicedetails'] = $this->vendorpaymentmodel->getDetail($paymentId);
            $page = 'vendorpayment/view_detai.php';
            $this->load->view($page, $result);
        }else{
              redirect('login', 'refresh');
        }
    }


    public function delVendorPayment()
    {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) 
        {
              $json_response = array();
               $vendorPaymentID = $this->input->post('vendorpaymentID');
               $voucherno = $this->input->post('voucherno');
              
               
               $user_activity_data =  array(
                                    "activity_date" => date("Y-m-d H:i:s"),
                                    "activity_module" => "Vendor Payment",
                                    "action" => "Delete",
                                    "narration" => $voucherno." deleted ID is ".$vendorPaymentID,
                                    "from_method" => "vendorpayment/delVendorPayment",
                                    "user_id" => $session['user_id']
                                 );

                $delete =  $this->vendorpaymentmodel->DeleteVendorPayment($vendorPaymentID,$user_activity_data);
                if($delete)
                {
                    $json_response = array(
                        "ERROR"=>0,
                        "MSG" => $voucherno ." successfully deleted"

                    );
                }
                else
                {
                    $json_response = array(
                        "ERROR"=>1,
                        "MSG" => "There is some problem.Please try again later"

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
