<?php

//we need to call PHP's session object to access it through CI
class Consignee extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('gstmastermodel', '', TRUE);
        $this->load->model('accountmastermodel', '', TRUE);
        $this->load->model('consigneemodel', '', TRUE);
       
    }




    public function index() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
        	
            $result = $this->consigneemodel->getConsigneeList($session['company'],$session['yearid']);
            $page = 'consignee_master/list_view';
            $header = '';
            $headercontent="";
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
      
    }


    public function addConsignee() {
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {

            if ($this->uri->segment(4) === FALSE) {

                $consigneeId = 0;
            } else {
                $consigneeId = $this->uri->segment(4);
            }
            //echo($salebillno);
            $result=[];
            $companyId=$session['company'];
            $yearId=$session['yearid'];
            $headercontent['account'] = $this->accountmastermodel->accountlist($session);
            $headercontent['states'] = $this->consigneemodel->getStates();
            $headercontent['customerlist'] = $this->consigneemodel->getCustomerList();
    
            if ($consigneeId != 0) {
                $headercontent['mode'] = "Edit";
                $headercontent["consigneedata"]= $this->consigneemodel->getConsigneeById($consigneeId);
                $headercontent['consigneeId']=$consigneeId;
                $page = 'consignee_master/add_view';
            } else {
                $headercontent['mode'] = "Add";
                $headercontent['consigneeId']="";
                $page = 'consignee_master/add_view';
                $result=NULL;
            }


            $header = '';

            /* load helper class to create view */

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }





	public function saveConsignee()
	{
		 $session = sessiondata_method();
		 if ($this->session->userdata('logged_in')) {
			
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			
			$consigneeId = $dataArry['consigneeId'];
			$consignee_name = $dataArry['consignee_name'];
			$address = $dataArry['address'];
			$state = $dataArry['state'];
			$gstin = $dataArry['gstin'];
			$customer = $dataArry['customer'];
			
			if($consigneeId>0)
			{
				$where_consignee = array(
					"consignee_master.id" => $consigneeId
				);
				$update_array = array(
									'consignee_name' => $consignee_name,
									'customer_id' => $customer,
									'address' => $address,
									'state_id' => $state,
									'gstin' => $gstin,
									'companyid' => $session['company'],
									'yearid' => $session['yearid'],
									 );

				$updateData=$this->consigneemodel->updateConsignee($update_array,$where_consignee);
				if($updateData)
				{
					$json_response = array(
						"msg_status" => 1,
						"msg_data" => "Updated successfully"
					);
				}
				else
				{
					$json_response = array(
						"msg_status" => 0,
						"msg_data" => "There is some problem while updating ...Please try again."
					);
				}
				
			}
			else
			{  

				$insert_array = array(
									'consignee_name' => $consignee_name,
									'customer_id' => $customer,
									'address' => $address,
									'state_id' => $state,
									'gstin' => $gstin,
									'companyid' => $session['company'],
									'yearid' => $session['yearid'],
									 );
				

				$insertData=$this->consigneemodel->insertConsignee($insert_array);
				if($insertData)
				{
					$json_response = array(
						"msg_status" => 1,
						"msg_data" => "Saved successfully"
					);
				}
				else
				{
					$json_response = array(
						"msg_status" => 0,
						"msg_data" => "There is some problem while saving ...Please try again."
					);
				}
			}
			
			
			
			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;
		
			
		}
		else
		{
			redirect('login','refresh');
		}
		
	}





} // End of class