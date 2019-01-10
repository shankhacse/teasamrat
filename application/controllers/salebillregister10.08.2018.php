<?php
    class salebillregister extends CI_Controller {
       function __construct() {
        parent::__construct();
        
        $this->load->model('salebillregistermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        $this->load->model('customermastermodel','',TRUE);
    $this->load->model('taxinvoicemodel','',TRUE);
		$this->load->model('gsttaxinvoicemodel','',TRUE);
    $this->load->model('teagroupmastermodel', '', TRUE);
       
    }
    
     public function index() {

        if ($this->session->userdata('logged_in')) {
           
            $session = sessiondata_method();
            $headercontent['customer'] = $this->salebillregistermodel->getCustomerList($session);
			      $headercontent['product'] = $this->taxinvoicemodel->getPacketProduct();
            $headercontent['finalproduct'] = $this->gsttaxinvoicemodel->getPacketProduct();

		      	$headercontent['taxtype'] = "VAT";
            $page = 'salebill_register/header_view';

            $header = "";
			$result="";
            createbody_method($result,$page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
	
	
	public function getsalebillregistergst()
	{
		if ($this->session->userdata('logged_in')) {
			
			$session = sessiondata_method();
            $headercontent['customer'] = $this->salebillregistermodel->getCustomerList($session);
			$headercontent['product'] = $this->taxinvoicemodel->getPacketProduct();
      $headercontent['teagrouplist'] =  $this->teagroupmastermodel->teagrouplist();

			$headercontent['taxtype'] = "GST";
			
            $page = 'salebill_register/header_view';
            $header = "";
			$result="";
            createbody_method($result,$page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
	}
	
	
	
    
      public function getSalebillRegister() {
          
         $session = sessiondata_method();
         $company = $session['company'];
		 $yearId = $session['yearid'];
         
        if($this->session->userdata('logged_in')) {
       $startdate = date('Y-m-d',  strtotime($this->input->post('startdate')));
        $enddate = date('Y-m-d',  strtotime($this->input->post('enddate')));
        $customer =  $this->input->post('customer');
		$product = $this->input->post("product");
    $taxtype = $this->input->post("taxtype");
		
		if($taxtype=="VAT")
        {
			$isGST = "N";
		}
		if($taxtype=="GST")
		{
			$isGST = "Y";
		}
        $value = array(
            'startDate'=>$startdate,
            'endDate'=>$enddate,
            'customerId'=>$customer,
			'product'=>$product,
			"isGST" => $isGST
        );
		
		$fdate = date('Y-m-d',strtotime($startdate));
		$tdate = date('Y-m-d',strtotime($enddate));
		$cid = $customer;
        
      //  $data['get_salebill_register'] = $this->salebillregistermodel->getSaleBillRegisterList($value,$company);
	  $data['get_salebill_register'] = $this->salebillregistermodel->getSaleBillRegisterData($fdate,$tdate,$cid,$company,$yearId,$isGST);
	  $this->db->freeDBResource($this->db->conn_id); 
		if($isGST=="N")
		{
			$page = 'salebill_register/list_view';
        }
		if($isGST=="Y")
		{
			$page = 'salebill_register/list_view_gst';
		}
		$view = $this->load->view($page, $data , TRUE );
        echo($view);
         } else {
            redirect('login', 'refresh');
        }
    }
    
    public function getsaleBillRegisterPdf(){
        $session = sessiondata_method();
        
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
        $startDate = $this->input->post('startdate');
        $endDate = $this->input->post('enddate');
        $customerId = $this->input->post('customer');
	    	$product = $this->input->post("product");
        $taxtype = $this->input->post("taxtype");
        $showtype = $this->input->post("showtype");
		    $detail_order_by = $this->input->post("billby");
        $finish_viewby = $this->input->post("finish_viewby");


		if($taxtype=="VAT")
        {
			$isGST = "N";
		}
		if($taxtype=="GST")
		{
			$isGST = "Y";
		}
        
        $value = array(
            'startDate'=>$startDate,
            'endDate'=>$endDate,
            'customerId'=>$customerId,
			'product'=>$product
        );
		
		$fdate = date('Y-m-d',strtotime($startDate));
		$tdate = date('Y-m-d',strtotime($endDate));
		 $cid = $customerId;
        $result['company'] = $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']= $this->companymodel->getCompanyAddressById($companyId);
        $result['printDate'] = date('d-m-Y');
        $this->load->library('pdf');
            $pdf = $this->pdf->load();
            ini_set('memory_limit', '256M'); 

// customer
             $in_customer = "";
             if ($customerId==0) {
                  //  echo "empty";
                   $customerlt = $this->salebillregistermodel->getCustomerList($session);

                    foreach ($customerlt as $customerlt) {
                      $in_customer.= $customerlt->vid;
                        $in_customer.=",";
                    }
                    $in_customer = rtrim($in_customer,',');
                    
                  }else{ $in_customer=$customerId;}


		if($isGST=="N")
		{

          $result['resultSalebill'] = $this->salebillregistermodel->getSaleBillRegisterData($fdate,$tdate,$cid,$companyId,$yearId,$isGST);
          $this->db->freeDBResource($this->db->conn_id); 
      
          
    			$page = 'salebill_register/salebill_register_pdf.php';
        }
 //edited on 05.05.2018       
		if($isGST=="Y")
		{
          if ($showtype=="All") {
           
         
             $result['resultSalebill'] = $this->salebillregistermodel->getSaleBillRegisterData($fdate,$tdate,$cid,$companyId,$yearId,$isGST,$detail_order_by);
             $this->db->freeDBResource($this->db->conn_id); 
          
             /*$this->load->library('pdf');
                $pdf = $this->pdf->load();
                ini_set('memory_limit', '256M');*/ 
                if($detail_order_by=='CW'){
        			 $page = 'salebill_register/salebill_register_gst_pdf.php';
               }else{
              $page = 'salebill_register/salebill_register_gst_pdf_bybill.php';

               }


          }else if ($showtype=="FPS") {
                //echo "fps";
                 $product = $this->input->post('product');
                 $in_product = "";

                         if (!empty($product)) {
                      //echo "not empty";
                      for($i=0;$i<sizeof($product);$i++)
                      { 
                        $in_product.= $product[$i];
                        $in_product.=",";
                      }
                   
                      //echo $in_product;
                    $in_product = rtrim($in_product,',');
                }
                  

                  if (empty($product)) {
                   // echo "empty";
                    $productlt=$this->gsttaxinvoicemodel->getPacketProduct();

                    foreach ($productlt as $productlt) {
                      $in_product.= $productlt['productPacketId'];
                        $in_product.=",";
                    }
                    $in_product = rtrim($in_product,',');
                    
                  }

            //echo $in_product;
        $result['resultSalebill'] = $this->salebillregistermodel->getSaleBillRegisterDataInvoiceGstDtl($fdate,$tdate,$in_customer,$in_product,$companyId,$yearId,$isGST);
             $this->db->freeDBResource($this->db->conn_id);  

             if ($finish_viewby=='QD') {
                   $page = 'salebill_register/salebill_register_invoice_gst_total_quantity_pdf.php'; 
                } else{

                   $page = 'salebill_register/salebill_register_invoice_gst_pdf.php';
                }        
          
          
          }else if ($showtype=="GTS") {
             //echo "gts";
           $group_code = $this->input->post('group_code');
                   
                  $in_group_code = "";

                      if (!empty($group_code)) {
                      //echo "not empty";
                      for($i=0;$i<sizeof($group_code);$i++)
                      { 
                        $in_group_code.= $group_code[$i];
                        $in_group_code.=",";
                      }
                   
                      
                    $in_group_code = rtrim($in_group_code,',');
                    }

                     if (empty($group_code)) {
                   // echo "empty";
                    $group_codelt= $this->teagroupmastermodel->teagrouplist();

                    foreach ($group_codelt as $group_codelt) {
                      $in_group_code.= $group_codelt->id;
                        $in_group_code.=",";
                    }
                    $in_group_code = rtrim($in_group_code,',');
                    
                  }

 // echo $in_group_code;
  $result['resultSalebill'] = $this->salebillregistermodel->getSaleBillRegisterDataGardenTeaGstDtl($fdate,$tdate,$in_customer,$in_group_code,$companyId,$yearId,$isGST);
             $this->db->freeDBResource($this->db->conn_id);           
          $page = 'salebill_register/salebill_register_garden_gst_pdf.php';


//pre($result['resultSalebill']);
//exit;
          } //end of GTS








		}
        
         
                
          $html = $this->load->view($page, $result, TRUE);
                $pdf->WriteHTML($html); 
                $output = 'salebill' . date('Y_m_d_H_i_s') . '_.pdf'; 
                $pdf->Output("$output", 'I');
                exit();
        
    }
    
 
    
    public function getsaleBillRegisterPrint(){
        
        $session = sessiondata_method();
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
        $startDate = $this->input->post('startdate');
        $endDate = $this->input->post('enddate');
        $customerId = $this->input->post('customer');
        
        $value = array(
            'startDate'=>$startDate,
            'endDate'=>$endDate,
            'customerId'=>$customerId
        );
        
        $data['resultSalebill'] = $this->salebillregistermodel->getSaleBillRegisterList($value);
        $result['company']=  $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']=  $this->companymodel->getCompanyAddressById($companyId);
        
            
        $this->load->library('pdf');
        $pdf = $this->pdf->load();
        ini_set('memory_limit', '256M'); 
       // $pdf = new mPDF('utf-8', array(203.2,152.4));
         
       
        $str='<html>'
              .'<head>'
              .'<title>SaleBill Register Pdf</title>'
              .'</head>'
              .'<body>';
                $str= $pdf->WriteHTML($str);  
                 $lncount=1;
           
                
                 /*--------------Company Detail-----------------------*/
       $str='<table width="100%">'
               .'<tr width="100%"><td align="center">'
               .'<span style="font-family:Verdana, Geneva, sans-serif; font-size:10px; font-weight:bold;">'.$result['company'].'<br>'. $result['companylocation']
               .'</span></td></tr>'
               .'</table>';
                $pdf->WriteHTML($str); 
               $lncount=$lncount+1;
                
                /*  Table Heading----------*/
        $str='<div style="margin-top:5%;"><table width="100%" cellspacing="4" cellpadding="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">'
              .'<tr>' 
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Customer</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">SaleBill No</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Salebill Dt</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Due Date</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Salebill Deatil</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Total Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Tax Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Discount Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Grand Total</td>'
              .'</tr>';
         $pdf->WriteHTML($str); 
       $lncount=$lncount+1;
       
         
         /* ------sale bill register data--------*/
         
            foreach($data['resultSalebill'] as $value){
               
                 $taxType=$value['taxrateType'];
                    if($taxType=='V'){
                    $taxAmountmt = "VAT: ".$value['taxamount'];
                    }
                    if($taxType=='C'){
                     $taxAmountmt = "CST:".$value['taxamount'];
                    }
                
                if($lncount>10){
                $pagebreak = $this->getheaderView($result['company'],$result['companylocation']);
                  $lncount=1;
                } 
                else{
                    $pagebreak='';
                }
            
                $str = '<tr style="background:#F7F7F7;text-align:center;">'
                       .'<td style="font-size:10px;">'.$value['customer_name']."Line Count".$lncount.'</td>' 
                       .'<td style="font-size:10px;">'.$value['salebillno'].'</td>' 
                       .'<td style="font-size:10px;">'.$value['SaleBlDt'].'</td>' 
                       .'<td style="font-size:10px;">'.$value['DueDt'].'</td>' 
                       .'<td>'
                       .'<table width="100%" cellspacing="4" cellpadding="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">'
                       .'<tr>'
                       .'<th width="40%">Product</th>'
                       .'<th>PackBox</th>'
                       .'<th>Net</th>'
                       .'<th>Rate</th>'
                       .'</tr>';
                
                 
                 $pdf->WriteHTML($str); 
                  $lncount=$lncount+1;
                 if($lncount>10){
                 $pagebreak = $this->getheaderView($result['company'],$result['companylocation']);
                  $lncount=1;
                } 
                else{
                    $pagebreak='';
                }
                 
                foreach ($value['salebilldetail'] as $detail){
                    
                   
                    
                    
                    $str = '<tr style="background:#E6E6E6;">'
                            .'<td width="40%">'.$detail['finalProduct'].'</td>'
                            .'<td>'.$detail['packingbox']."Line Count".$lncount.'</td>'
                            .'<td>'.$detail['packingnet'].'</td>'
                            .'<td>'.$detail['rate'].'</td>'
                            .'</tr>'; 
                    $pdf->WriteHTML($str);    
                    $lncount=$lncount+1;
                    if($lncount>10){
                $pagebreak = $this->getheaderView($result['company'],$result['companylocation']);
                  $lncount=1;
                } 
                else{
                    $pagebreak='';
                }
                }
                 $str= '</table></td>';
                 $pdf->WriteHTML($str);    
                
                    $str= '<td>'.$value['totalamount'].'</td>'
                       .'<td>'.$taxAmountmt.'</td>' 
                       .'<td>'.$value['discountAmount'].'</td>' 
                       .'<td>'.$value['grandtotal'].'</td>' 
                       .'</tr>'.$pagebreak;
                    
              $pdf->WriteHTML($str); 
              $lncount=$lncount+1;
             /* if($lncount>10){
                $pagebreak = $this->getheaderView($result['company'],$result['companylocation']);
                  $lncount=1;
                } 
                else{
                    $pagebreak='';
                }*/
              $pdf->setFooter("Page {PAGENO} of {nb}");
            
                
            }
         
        
        
        
       $str='</table></div>';  
       $pdf->WriteHTML($str); 
           
       $str = '</body></html>';
       $pdf->WriteHTML($str); 
      
        $output = 'salebillregister' . date('Y_m_d_H_i_s') . '_.pdf'; 
        $pdf->Output("$output", 'I');
        exit();
        
        
        
    }
    
    
    
    
    
    
    
  public function getheaderView($com,$loc){
        $header ='</table></div><pagebreak /><table width="100%">'
               .'<tr width="100%"><td align="center">'
               .'<span style="font-family:Verdana, Geneva, sans-serif; font-size:10px; font-weight:bold;">'.$com.'<br>'.$loc
               .'</span></td></tr>'
               .'</table><div style="margin-top:5%;"><table width="100%" cellspacing="4" cellpadding="2" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">'
              .'<tr>' 
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Customer</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">SaleBill No</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Salebill Dt</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Due Date</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Salebill Deatil</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Tax Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Discount Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Total Amt.</td>'
              .'<td style="background:#E9E9E9;text-align:center;font-size:10px;font-weigth:bold;border:1px solid #323232;">Grand Total</td>'
              .'</tr>';
        return $header;
                
        
    }
   
    
}
?>