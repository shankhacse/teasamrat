<?php

//we need to call PHP's session object to access it through CI
class shortageadjustment extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('shortagemodel', '', TRUE);
        $this->load->model('transportmastermodel', '', TRUE);
        $this->load->model('companymodel', '', TRUE);
        
    }

    public function index() {
        $session = sessiondata_method();
        $this->companyId = $session['company'];
        $this->yearId = $session['yearid'];
        $selected_transporter = $this->input->post('drpTransporter');
        $selected_invoice = $this->input->post('invoice');

       

        if ($this->session->userdata('logged_in')) {

             $result['transporterlist'] = $this->transportmastermodel->transportlist();
             $result['purchaseInvoice'] = $this->shortagemodel->getPurchaseInvoice($session['company']);
             if($selected_transporter != 0 && $selected_invoice!=0 ){
                 
                $result['invoiceBagDtls'] = $this->shortagemodel->getBagDetails($selected_invoice,$selected_transporter);
                $result['selected_transporter'] = $selected_transporter;
                $result['selected_inpoice'] = $selected_invoice;
                 
             }else{
                 $result['invoiceBagDtls']='';
                 $result['selected_transporter'] = 0;
                 $result['selected_inpoice'] = 0;
                
             }
           
        } else {
            redirect('login', 'refresh');
        }


        $headercontent = '';
        $page = 'shortage/header_view';
        $header = '';
        /* load helper class to create view */
        createbody_method($result, $page, $header, $session, $headercontent);
    }
    /*
     * @method addShortage
     * 
     */

   public function addShortage(){
       $PurchaseBagDetailIds = $this->input->post('bagDtlId');
       $numberOfBags=  $this->input->post('noBags');
       $shortage=  $this->input->post('shortage');
       $challanno = $this->input->post('challanno');
               
       $challandate = ($this->input->post('challandate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('challandate'))));
       
       $parentBagNet=  $this->input->post('pBagNet');
       $pActualBag = $this->input->post('pActualBag');
       $purchaseDetailId = $this->input->post('purchaseDtlId');
       
       $shortageNet = ($parentBagNet - $shortage);
       $parentActualBagCal = $pActualBag-$numberOfBags;
       
       $Shortdata=array('purchasedtlid'=>$purchaseDetailId,
                    'bagtypeid'=>3,
                    'no_of_bags'=>$numberOfBags,
                    'net'=>$shortageNet,
                    'shortkg'=>$shortage,
                    'challanno'=>$challanno,
                    'challandate'=>$challandate,
                    'parent_bag_id'=>$PurchaseBagDetailIds,
                    'actual_bags'=>$numberOfBags
           );
       $parentbagdata=array(
           'actual_bags'=>$parentActualBagCal
       );
       
       $result=$this->shortagemodel->InsertShortage($PurchaseBagDetailIds,$Shortdata,$parentbagdata);
       
   }
   
   
   public function updateShortage(){
       $PurchaseBagDetailIds = $this->input->post('bagDtlId');
      
       $numberOfBags=  $this->input->post('noBags');
       $shortage=  $this->input->post('shortage');
       
       $challanno = $this->input->post('challanno');
       
     
       $challandate = ($this->input->post('challandate') == "" ? NULL : date("Y-m-d", strtotime($this->input->post('challandate'))));
      
       $shortActualBag = $this->input->post('shortActualBag');
       $purchaseDetailId = $this->input->post('purchaseDtlId');
       
       $parentId = $this->input->post('parentBagId');
       
       $actualBagOfParent=$this->shortagemodel->getParentActualBag($parentId);
       
       $parentBagNet=  $this->shortagemodel->getParentBagNet($parentId);
       
       $shortageNet = ($parentBagNet - $shortage);
      
       $parentActualBagCal = ($actualBagOfParent + $shortActualBag)-$numberOfBags;
       
       $Shortdata=array(
                    'no_of_bags'=>$numberOfBags,
                    'net'=>$shortageNet,
                    'shortkg'=>$shortage,
                    'challanno'=>$challanno,
                    'challandate'=>$challandate,
                    'actual_bags'=>$numberOfBags
           );
       $parentbagdata=array(
           'actual_bags'=>$parentActualBagCal
       );
       
       $result=$this->shortagemodel->update($PurchaseBagDetailIds,$Shortdata,$parentbagdata,$parentId);
       
   }
   
   public function deleteShortage(){
       $purchaseBagDetailId =$this->input->post('bagDtlId');
       $numberofbags=  $this->input->post('noBags');
       $parentBagId=  $this->input->post('parentBagId');
       $actualBagOfParent=$this->shortagemodel->getParentActualBag($parentBagId);
       $numberOfParentBagsAfterDel = $actualBagOfParent + $numberofbags;
       
       $dataOfPbag = array(
           'actual_bags'=>$numberOfParentBagsAfterDel
       );
       
       $this->shortagemodel->deleteShortBag($purchaseBagDetailId,$parentBagId,$dataOfPbag);
   }
   public function returnDelete(){
	$purchaseBagDetailId =$this->input->post('bagdtlid');
	$res=$this->shortagemodel->deleteReturnBag($purchaseBagDetailId);
	if($res){
		echo(1);
	}else{
		echo(0);
	}
   }
   
   public function getNetWeightOfBag(){
	$netWeight= array();
	$bagDetailId = $this->input->post("bagDetailsId");
	$netWeight = $this->shortagemodel->getParentBagNetandNoBags($bagDetailId);
	header('Content-Type: application/json');
    echo json_encode($netWeight);
   
   }
   /**
   *@method saveReturn
   *@date 05/12/2016
   **/
   public function saveReturn(){
		$bagsReturn = $this->input->post("bagsReturn");
		$netInBag = $this->input->post("netInBag");
		$returnChallan = $this->input->post("returnChallan");
		$returnChallanDate =($this->input->post('returnChallanDate')=="" ? NULL:date("Y-m-d",strtotime($this->input->post('returnChallanDate'))));
		$parentBagId = $this->input->post("bagDetailsId");
		
		$dataReturnBag=array(
							"purchasedtlid"=>$this->getPdtlIdByParent($parentBagId),
							"bagtypeid"=>4,
							"no_of_bags"=>$bagsReturn,
							"net"=>$netInBag,
							"shortkg"=>0,
							"parent_bag_id"=>$parentBagId,
							"actual_bags"=>$bagsReturn,
							"chestSerial"=>null,
							"challanno"=>$returnChallan,
							"challandate"=>$returnChallanDate
		);
		//echo('<pre>');print_r($dataReturnBag);echo('</pre>');
		$result = $this->shortagemodel->SaveReturnBag($dataReturnBag);
		if($result==true){
			echo(1);
		}else{
			echo(0);
		}
		
   
   }
   /*
   *
   */
   public function getPdtlIdByParent($id){
   $purchaseDetailId = $this->shortagemodel->getPdtlIdByParent($id);
   return $purchaseDetailId;
   
   }


    public function shortageDetails() {
        
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            
            $companyId = $session['company'];
            $yearId =$session['yearid'];
            $selected_transporter = $this->input->post('drpTransporter');
            $selected_invoice = $this->input->post('invoice');

             $result['transporterlist'] = $this->transportmastermodel->transportlist();
             $result['purchaseInvoice'] = $this->shortagemodel->getPurchaseInvoice($session['company']);

             if($selected_transporter != 0 && $selected_invoice!=0 ){
                 
                $result['invoiceBagDtls'] = $this->shortagemodel->getBagDetails($selected_invoice,$selected_transporter);
                $result['selected_transporter'] = $selected_transporter;
                $result['selected_inpoice'] = $selected_invoice;
                 
             }else{
                 $result['invoiceBagDtls']='';
                 $result['selected_transporter'] = 0;
                 $result['selected_inpoice'] = 0;
                
             }

             $fiscalDt = $this->shortagemodel->getFiscalStartDt($yearId);
             $result['fiscalStartDt'] = $fiscalDt->start_date;
             $result['fiscalEndtDt'] = $fiscalDt->end_date;
         
            $page = 'shortage/detail_view.php';
            $header = '';
            $headercontent="";

            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }  


     //------------------------------------------------------ 
   public function getshortageRegisterPdf(){
        $session = sessiondata_method();
        
        $companyId = $session['company'];
        $yearId = $session['yearid'];
        
        $startDate = $this->input->post('startdate');
        $endDate = $this->input->post('enddate');
        $invoice = $this->input->post('invoice');
        $drpTransporter = $this->input->post('drpTransporter');
       

        $fdate = date('Y-m-d',strtotime($startDate));
        $tdate = date('Y-m-d',strtotime($endDate));

        
        $result['company'] = $this->companymodel->getCompanyNameById($companyId);
        $result['companylocation']= $this->companymodel->getCompanyAddressById($companyId);
        $result['printDate'] = date('d-m-Y');

          $this->load->library('pdf');
            $pdf = $this->pdf->load();
            ini_set('memory_limit', '256M'); 

       $result['resultshortage'] = $this->shortagemodel->shortageRegByDate($fdate,$tdate,$invoice,$drpTransporter);

         /*  echo "<pre>";
            print_r($result['resultshortage']);
            echo "</pre>";
             exit;*/
              $page = 'shortage/shortage_register_pdf.php';
           
          $this->load->view($page, $result);
         
                
        
         $html = $this->load->view($page, $result, TRUE);
                $pdf->WriteHTML($html); 
                $output = 'shortage' . date('Y_m_d_H_i_s') . '_.pdf'; 
                $pdf->Output("$output", 'I');
                exit();
       
    

        }
   //------------------------------------------------------ 
   
}

?>
