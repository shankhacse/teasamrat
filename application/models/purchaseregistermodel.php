<?php
class purchaseregistermodel extends CI_Model {
	
	/*Purchase register*/
	
	public function getPurchaseRegisterWithOptions($value)
	{
		$data = array();
        
		//print_r($value);
		
        $vendorClause = "";
        if ($value['vendorId'] != 0) {
            $vendorClause = " AND purchase_invoice_master.vendor_id=".$value['vendorId'];
        }
        
        $saleNo = "";
        if ($value['saleNumber'] != "") {
           $saleNo = " AND purchase_invoice_master.sale_number='" . $value['saleNumber'] . "'";
        }
        
		$purchaseType = "";
		if($value['purType']!="0" )
		{
			$purchaseType = " AND purchase_invoice_master.from_where='".$value['purType']."'";
		}
		
        $PurchaseArea = "";
        if ($value['area'] != 0) {
            $PurchaseArea = " AND purchase_invoice_master.auctionareaid='" . $value['area'] . "'";
        }
		/*
		$groupType = "";
		if($value['area'] != 0)
		{
			$groupType = " AND purchase_invoice_detail.teagroup_master_id=".$value['groupID'];
		}*/
		
		
	 $sql = "SELECT 
			purchase_invoice_master.`id` AS pMastID,
			purchase_invoice_master.`purchase_invoice_number`,
			purchase_invoice_master.`purchase_invoice_date`,
			purchase_invoice_master.`sale_number`,
			purchase_invoice_master.`sale_date`,
			purchase_invoice_master.`promt_date`,
			purchase_invoice_master.`round_off`,
			purchase_invoice_master.`other_charges`,
			purchase_invoice_master.`total`,
			vendor.vendor_name
			FROM
			purchase_invoice_master 
			INNER JOIN vendor
			ON vendor.id=purchase_invoice_master.vendor_id
			WHERE purchase_invoice_master.`from_where` NOT IN ('OP', 'STI') 
			AND purchase_invoice_master.isGST <> 'Y'
			AND purchase_invoice_master.`company_id`=".$value['compID']."
			AND purchase_invoice_master.`year_id`=".$value['yid']."
			AND purchase_invoice_master.`purchase_invoice_date` BETWEEN '".$value['startDate']."' AND '".$value['endDate']."' 
			".$vendorClause.$saleNo.$purchaseType.$PurchaseArea."
			ORDER BY purchase_invoice_master.`purchase_invoice_date`";
			
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) 
		{
            foreach ($query->result() as $rows) {
                $data[] = array(
						"pMastID" => $rows->pMastID,
                        "purchase_invoice_number" => $rows->purchase_invoice_number,
                        "purchase_invoice_date" => $rows->purchase_invoice_date,
                        "sale_number" => $rows->sale_number,
                        "sale_date" => $rows->sale_date,
                        "promt_date" => $rows->promt_date,
                        "round_off" => $rows->round_off,
                        "other_charges" => $rows->other_charges,
                        "total" => $rows->total,
						"vendor_name" => $rows->vendor_name,
						"purchaseDtl" => $this->getPurchaseDetailSum($rows->pMastID),
						"bagDtl" => $this->getBagDetails($rows->pMastID)
					);
            }
            return $data;
        } 
		
		
	}
	
	public function getPurchaseRegisterGSTWithOptions($value)
	{
		$data = array();
        
		//print_r($value);
		
        $vendorClause = "";
        if ($value['vendorId'] != 0) {
            $vendorClause = " AND purchase_invoice_master.vendor_id=".$value['vendorId'];
        }
        
        $saleNo = "";
        if ($value['saleNumber'] != "") {
           $saleNo = " AND purchase_invoice_master.sale_number='" . $value['saleNumber'] . "'";
        }
        
		$purchaseType = "";
		if($value['purType']!="0" )
		{
			$purchaseType = " AND purchase_invoice_master.from_where='".$value['purType']."'";
		}
		
        $PurchaseArea = "";
        if ($value['area'] != 0) {
            $PurchaseArea = " AND purchase_invoice_master.auctionareaid='" . $value['area'] . "'";
        }
		/*
		$groupType = "";
		if($value['area'] != 0)
		{
			$groupType = " AND purchase_invoice_detail.teagroup_master_id=".$value['groupID'];
		}*/
		
		
	$sql = "SELECT 
			purchase_invoice_master.`id` AS pMastID,
			purchase_invoice_master.`purchase_invoice_number`,
			purchase_invoice_master.`purchase_invoice_date`,
			purchase_invoice_master.`sale_number`,
			purchase_invoice_master.`sale_date`,
			purchase_invoice_master.`promt_date`,
			purchase_invoice_master.`tea_value`,
			purchase_invoice_master.`GST_totalcgst`,
			purchase_invoice_master.`GST_totalsgst`,
			purchase_invoice_master.`GST_totaligst`,
			purchase_invoice_master.`GST_gstincldamt`,
			purchase_invoice_master.`round_off`,
			purchase_invoice_master.`other_charges`,
			purchase_invoice_master.`total`,
			vendor.vendor_name
			FROM
			purchase_invoice_master 
			INNER JOIN vendor
			ON vendor.id=purchase_invoice_master.vendor_id
			WHERE purchase_invoice_master.`from_where` NOT IN ('OP', 'STI') 
			AND purchase_invoice_master.isGST = 'Y'
			AND purchase_invoice_master.`company_id`=".$value['compID']."
			AND purchase_invoice_master.`year_id`=".$value['yid']."
			AND purchase_invoice_master.`purchase_invoice_date` BETWEEN '".$value['startDate']."' AND '".$value['endDate']."' 
			".$vendorClause.$saleNo.$purchaseType.$PurchaseArea."
			ORDER BY purchase_invoice_master.`purchase_invoice_date`";
			
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) 
		{
            foreach ($query->result() as $rows) {
                $data[] = array(
						"pMastID" => $rows->pMastID,
                        "purchase_invoice_number" => $rows->purchase_invoice_number,
                        "purchase_invoice_date" => $rows->purchase_invoice_date,
                        "sale_number" => $rows->sale_number,
                        "sale_date" => $rows->sale_date,
                        "promt_date" => $rows->promt_date,
                        "round_off" => $rows->round_off,
                        "other_charges" => $rows->other_charges,
                        "total" => $rows->total,
						"vendor_name" => $rows->vendor_name,
						"GST_gstincldamt" => $rows->GST_gstincldamt,
						"purchaseDtl" => $this->getPurchaseDetailSum($rows->pMastID),
						"bagDtl" => $this->getBagDetails($rows->pMastID)
					);
            }
            return $data;
        } 
		
		
	}
	
	
	public function getPurchaseDetailSum($mastID)
	{
		$data = array();
		$sql="SELECT 
				IFNULL(SUM(purchase_invoice_detail.`brokerage`),0) AS totalBrokrage,
				IFNULL(SUM(purchase_invoice_detail.`rate_type_value`),0) AS totalTaxAmt,
				IFNULL(SUM(purchase_invoice_detail.`service_tax`),0) AS serviceTaxAmt,
				IFNULL(SUM(purchase_invoice_detail.`tb_charges`),0) AS totalTBCharges,
				IFNULL(SUM(purchase_invoice_detail.`value_cost`),0) AS teaValue,
				IFNULL(SUM(purchase_invoice_detail.`stamp`),0) AS totalStamp,
				IFNULL(SUM(purchase_invoice_detail.`gst_taxable`),0) AS gst_taxable,
				IFNULL(SUM(purchase_invoice_detail.`cgst_amt`),0) AS cgst_amt,
				IFNULL(SUM(purchase_invoice_detail.`sgst_amt`),0) AS sgst_amt,
				IFNULL(SUM(purchase_invoice_detail.`igst_amt`),0) AS igst_amt,
				IFNULL(SUM(purchase_invoice_detail.`gst_netamount`),0) AS gst_netamount,
				purchase_invoice_detail.rate_type
				#IFNULL(SUM(purchase_invoice_detail.total_value),0) AS totalValue
			FROM
				purchase_invoice_detail
				WHERE purchase_invoice_detail.`purchase_master_id`=".$mastID;
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
                $data = array(
					"totalBrokerage" => $row->totalBrokrage,
					"totalTaxAmt" => $row->totalTaxAmt,
					"serviceTaxAmt" => $row->serviceTaxAmt,
					"totalTBCharges" => $row->totalTBCharges,
					"teaValue" => $row->teaValue,
					"totalStamp" => $row->totalStamp,
					"rate_type" => $row->rate_type,
					"gst_taxable" => $row->gst_taxable,
					"cgst_amt" => $row->cgst_amt,
					"sgst_amt" => $row->sgst_amt,
					"igst_amt" => $row->igst_amt,
					"gst_netamount" => $row->gst_netamount
					
					
					);
           return $data;
        } 
	
	}
	
	public function getBagDetails($mastID)
	{
		$data = array();
		$sql = "SELECT 
				IFNULL(SUM(purchase_bag_details.`actual_bags`),0) AS actualBag,
				IFNULL(SUM(`purchase_bag_details`.`net` * `purchase_bag_details`.`no_of_bags`),0) AS totalkgs
				FROM purchase_bag_details
				WHERE purchase_bag_details.`purchasedtlid` IN 
				(SELECT `purchase_invoice_detail`.id FROM `purchase_invoice_detail` WHERE purchase_invoice_detail.`purchase_master_id`=".$mastID.")";
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) 
		{
			$row = $query->row();
                $data = array(
					"actualBag" => $row->actualBag,
					"totalkgs" => $row->totalkgs
					);
           return $data;
        } 
		
	}
	
	/*------------------Purchase Register Group Wise--------------------*/
	
	public function getPurchaseRegisterGroupWise($value)
	{
		$data = array();
		
		$dateClause="";
		if($value['startDate']!="" AND $value['endDate']!="")
		{
			$dateClause = " AND purchase_invoice_master.`purchase_invoice_date` BETWEEN '".$value['startDate']."' AND '".$value['endDate']."'";
		}
		
		$sql = "SELECT * FROM purchase_invoice_detail
				INNER JOIN purchase_invoice_master
				ON purchase_invoice_master.`id`=purchase_invoice_detail.`purchase_master_id`
				INNER JOIN vendor
				ON vendor.`id` = purchase_invoice_master.`vendor_id`
				WHERE 
				purchase_invoice_master.`from_where` NOT IN ('OP','STI') ".$dateClause."
				AND purchase_invoice_master.`company_id`=".$value['compID']."
				AND purchase_invoice_master.`year_id`=".$value['yearID']."
				AND purchase_invoice_detail.`teagroup_master_id`=".$value['group']."
				AND purchase_invoice_master.isGST <> 'Y'
				GROUP BY purchase_invoice_master.`id`";
				
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) 
		{
            foreach ($query->result() as $rows) {
               $data[] = [
					"purchaseData" => $rows,
					"bagDtlData" => $this->getBagDetailsData($rows->purchase_master_id)
				];
            }
            return $data;
        } 
		
	}
	
	
	/*------------------Purchase Register Group Wise--------------------*/
	
	public function getPurchaseRegisterGSTGroupWise($value)
	{
		$data = [];
		
		$dateClause="";
		if($value['startDate']!="" AND $value['endDate']!="")
		{
			$dateClause = " AND purchase_invoice_master.`purchase_invoice_date` BETWEEN '".$value['startDate']."' AND '".$value['endDate']."'";
		}
		
		/*
		$sql = "SELECT * FROM purchase_invoice_detail
				INNER JOIN purchase_invoice_master
				ON purchase_invoice_master.`id`=purchase_invoice_detail.`purchase_master_id`
				INNER JOIN vendor
				ON vendor.`id` = purchase_invoice_master.`vendor_id`
				WHERE 
				purchase_invoice_master.`from_where` NOT IN ('OP','STI') ".$dateClause."
				AND purchase_invoice_master.`company_id`=".$value['compID']."
				AND purchase_invoice_master.`year_id`=".$value['yearID']."
				AND purchase_invoice_detail.`teagroup_master_id`=".$value['group']."
				GROUP BY purchase_invoice_master.`id`";
		*/
		
		 $sql = "SELECT 
				  purchase_invoice_master.purchase_invoice_number,
				  purchase_invoice_master.purchase_invoice_date,
				  purchase_invoice_master.sale_number,
				  purchase_invoice_detail.`id` AS purchaseDtlID,
				  purchase_invoice_detail.`purchase_master_id`,
				  purchase_invoice_detail.`lot`,
				  purchase_invoice_detail.`doRealisationDate`,
				  purchase_invoice_detail.`do`,
				  purchase_invoice_detail.`invoice_number`,
				  purchase_invoice_detail.`price`,
				  purchase_invoice_detail.`total_value`,
				  purchase_invoice_detail.`value_cost`,
				  SUM(purchase_invoice_detail.`gst_taxable`) AS taxableAmt,
				  SUM(purchase_invoice_detail.`cgst_amt`) AS cgstAmt,
				  SUM(purchase_invoice_detail.`sgst_amt`) AS sgstAmt,
				  SUM(purchase_invoice_detail.`igst_amt`) AS igstAmt,
				  purchase_invoice_master.GST_gstincldamt,
				  purchase_invoice_master.total,
				  purchase_invoice_master.round_off,
				  vendor.vendor_name
				FROM
				  purchase_invoice_detail 
				  INNER JOIN purchase_invoice_master 
					ON purchase_invoice_master.`id` = purchase_invoice_detail.`purchase_master_id` 
				  INNER JOIN vendor 
					ON vendor.`id` = purchase_invoice_master.`vendor_id` 
				WHERE purchase_invoice_master.`from_where` NOT IN ('OP','STI') ".$dateClause."
					AND purchase_invoice_master.`company_id`=".$value['compID']."
					AND purchase_invoice_master.`year_id`=".$value['yearID']."
					AND purchase_invoice_detail.`teagroup_master_id`=".$value['group']."
				   AND purchase_invoice_master.`isGST` = 'Y'
				GROUP BY purchase_invoice_master.`id` ORDER BY purchase_invoice_master.purchase_invoice_date ";
				
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) 
		{
            foreach ($query->result() as $rows) {
				$data[] = [
					"purchaseData" => $rows,
					"bagDtlData" => $this->getBagDetailsData($rows->purchase_master_id)
				];
               
            }
        } 
		return $data;
		
	}
	

	private function getBagDetailsData($purchaseMasterID)
	{
		$bagDtlAry = [];
		$sql = "SELECT * FROM purchase_bag_details
				WHERE purchase_bag_details.`purchasedtlid` IN 
				(
				SELECT purchase_invoice_detail.`id` FROM purchase_invoice_detail
				WHERE purchase_invoice_detail.`purchase_master_id` = ".$purchaseMasterID.")";
		
		$totalBag = 0;
		$totalNetKgs = 0;
		
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) 
		{
			$perbagkgs = 0;
            foreach($query->result() as $rows) {
                $totalBag+=$rows->no_of_bags;
				$perbagkgs = $rows->no_of_bags*$rows->net;
				$totalNetKgs+=$perbagkgs;
            }
			
			$bagDtlAry = [
				"totalBags" => $totalBag,
				"totalKgs" => $totalNetKgs
			];
        }
		return $bagDtlAry;		
	}
	
	
	
	public function getPurchaseRegister($fromDt,$toDt,$vendor,$compny,$year)
	{
		 $data = array();
		 $call_procedure = "CALL SP_PurchaseRegisterAll('".$fromDt."','".$toDt."',".$vendor.",".$compny.",".$year.")";
		  //echo $call_procedure;
		 $query = $this->db->query($call_procedure);
		 $sql = "SELECT * FROM purchaseRegMaster ORDER BY invoiceDate ASC";
		 $query = $this->db->query($sql);
		 
		  if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                        "invoiceNumber" => $rows->invoiceNumber,
                        "invoiceDate" => $rows->invoiceDate,
                        "totalAmount" => $rows->totalAmount,
                        "roundOff" => $rows->roundOff,
                        "vendorName" => $rows->vendorName
						
                     );
            }
           
           
            return $data;
        } 
        
        else
		{
            return $data;
        }
	}
        
        public function generateGstPurchaseRegister($companyId,$yearId,$fromDate,$toDate,$vendor){
            $data=array();
			if(strlen($vendor)>0)
			{
				$call_procedure = "CALL sp_gstPurchaseRegisterVendorWise(".$companyId.",".$yearId.",'".$fromDate."','".$toDate."','".$vendor."')";
			}
			else
			{
				$call_procedure = "CALL sp_gstPurchaseRegister(".$companyId.",".$yearId.",'".$fromDate."','".$toDate."')";	
			}

            $query = $this->db->query($call_procedure);
            if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                        "vendorname" => $rows->vendorname,
                        "vendorId" => $rows->vendorId,
                        "BillNo" => $rows->BillNo,
                        "BillDate" => $rows->BillDate,
                        "taxableamount" => $rows->taxableamount,
                        "cgstamount" => $rows->cgstamount,
                        "sgstamount" => $rows->sgstamount,
                        "igstamount" => $rows->igstamount,
                        "gstincludedamt" =>($rows->cgstamount + $rows->sgstamount+$rows->igstamount) ,        //$rows->gstincludedamt,
                        "roundoff" => $rows->roundoff,
                        "billtotal" => $rows->billtotal

						
                     );
                }
            }
            return $data;
        }
        
	
	public function getPurchaseRegSumData()
	{
		$data = array(
            "toatlVAT" => $this->getTotalVatAmountByVATRate(), // getting vat amount by rate
            "totalCST" => $this->getTotalCSTAmountByCSTRate(),
			"totalBrokerage" => $this->getTotalBrokerageAmt(),
			"totalExciseAmt" => $this->getTotalExciseAmt(),
			"totalDiscAmt" => $this->getTotalDiscountAmt()
            );
        return $data;
        
	}
	
	public function getTotalVatAmountByVATRate()
	{
		$data = array();
		 $sql = "SELECT SUM(taxAmount) AS totalVATAmt ,vat.`vat_rate`
				FROM purchaseRegDetail 
				LEFT JOIN vat
				ON vat.`id` = purchaseRegDetail.rateTypeID AND purchaseRegDetail.rateType='V'
				WHERE purchaseRegDetail.rateType='V'
				GROUP BY purchaseRegDetail.rateTypeID , purchaseRegDetail.rateType='V'";
		 $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                        "vatAmount" => $rows->totalVATAmt,
                        "vat_rate" => $rows->vat_rate
                    );
            }
           return $data;
        } 
        else
		{
            return $data;
        }
	}
	
	public function getTotalCSTAmountByCSTRate()
	{
		$data = array();
		$sql = "SELECT SUM(taxAmount) AS totalCSTAmt ,cst.`cst_rate`
				FROM purchaseRegDetail 
				LEFT JOIN cst
				ON cst.`id` = purchaseRegDetail.rateTypeID AND purchaseRegDetail.rateType='C'
				WHERE purchaseRegDetail.rateType='C'
				GROUP BY purchaseRegDetail.rateTypeID , purchaseRegDetail.rateType='C'";
		 $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                        "cstAmount" => $rows->totalCSTAmt,
                        "cst_rate" => $rows->cst_rate
                    );
            }
           return $data;
        } 
        else
		{
            return $data;
        }
	}
	
	public function getTotalBrokerageAmt()
	{
		$totalBrokerage = 0;
		$sql = "SELECT SUM(brokerage) AS totalBrokerage
				FROM purchaseRegDetail";
		 $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) 
		  {
			  $row = $query->row();
			  $totalBrokerage = $row->totalBrokerage;
               
          } 
		  return $totalBrokerage;
        
	}
	
	public function getTotalExciseAmt()
	{
		$totalExciseAmount = 0;
		$sql = "SELECT SUM(exciseAmt) AS totalExciseAmt
				FROM purchaseRegDetail";
		 $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) 
		  {
			  $row = $query->row();
			  $totalExciseAmount = $row->totalExciseAmt;
               
          } 
		  return $totalExciseAmount;
        
	}
	
	
	public function getTotalDiscountAmt()
	{
		$totalDiscountAmt = 0;
		$sql = "SELECT SUM(discountAmt) AS totalDiscountAmt
				FROM purchaseRegDetail";
		 $query = $this->db->query($sql);
		  if ($query->num_rows() > 0) 
		  {
			  $row = $query->row();
			  $totalDiscountAmt = $row->totalDiscountAmt;
               
          } 
		  return $totalDiscountAmt;
        
	}
	
	public function getVendorNameByID($vendorID)
	{
		$vendor_name = "";
		$sql = "SELECT vendor.`vendor_name` FROM vendor WHERE vendor.`id`=".$vendorID;
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$vendor_name = $row->vendor_name;
		}
		return $vendor_name;
	}
	
	public function getTeaGroup($teagrpID)
	{
		$groupname = "";
		$sql = "SELECT * FROM teagroup_master WHERE teagroup_master.id=".$teagrpID;
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$groupname = $row->group_description;
		}
		return $groupname;
	}
	
	public function getPurchaseAreaByID($actionareaID)
	{
		$auctionarea = "";
		$sql = "SELECT * FROM auctionareamaster WHERE auctionareamaster.id=".$actionareaID;
		$query = $this->db->query($sql);
		if($query->num_rows()>0)
		{
			$row = $query->row();
			$auctionarea = $row->auctionarea;
		}
		return $auctionarea;
	}
	
}
	
	
	
	
	
	
	
	
