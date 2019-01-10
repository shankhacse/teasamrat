<?php
class checkdatamodel extends CI_Model {
	public function checkIsDataExist($table,$where)
	{
		$data = [];
		$this->db->select('*')
				->from($table)
				->where($where);
		$query = $this->db->get();

		
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }

	}


	public function checkCustomerAdjustmentAgainstBill($salebill_id,$sale_type)
	{
		$data = [];
		$where = array(
			"customerbillmaster.invoicemasterid" => $salebill_id,
			"customerbillmaster.saletype" => $sale_type
		);

		$this->db->select('*')
			->from('customeradvanceadjstdtl')
			->join('customeradvanceadadjustment','customeradvanceadadjustment.adjustmentid = customeradvanceadjstdtl.custadjmstid','INNER')
			->join('customerbillmaster','customerbillmaster.customerbillmasterid = customeradvanceadjstdtl.customerbillmaster','INNER')
			->where($where);
				
		$query = $this->db->get();
		//echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}

	public function checkCustomerReceiptAgainstBill($salebill_id,$sale_type)
	{
		$data = [];
		$where = array(
			"customerbillmaster.invoicemasterid" => $salebill_id,
			"customerbillmaster.saletype" => $sale_type
		);

		$this->db->select('*')
			->from('customerreceiptdetail')
			->join('customerreceiptmaster','customerreceiptmaster.customerpaymentid = customerreceiptdetail.customerrecptmstid','INNER')
			->join('customerbillmaster','customerbillmaster.customerbillmasterid = customerreceiptdetail.customerbillmasterid','INNER')
			->join('voucher_master','voucher_master.id = customerreceiptmaster.voucherid','INNER')
			->where($where);
				
		$query = $this->db->get();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}


	// Cheking For Service Purchase Adjustment
	/*
	* @method : checkVendorAdjustmentAgainstBill
	* @date : 27.03.2018
	* By : Mithilesh
	* Table Considered : vendoradjustmentdetails,vendoradvanceadjustmentmaster,vendorbillmaster,rawmaterial_purchase_master
	*/
	public function checkVendorAdjustmentAgainstBill($purchase_id,$purchase_type)
	{
		$data = [];
		$where = array(
			"vendorbillmaster.invoiceMasterId" => $purchase_id,
			"vendorbillmaster.purchaseType" => $purchase_type,
			"rawmaterial_purchase_master.IsService" => 'Y'
		);

	$this->db->select('*')
	->from('vendoradjustmentdetails')
	->join('vendoradvanceadjustmentmaster',' vendoradvanceadjustmentmaster.AdjustmentId = vendoradjustmentdetails.vendAdjstMstId','INNER')
	->join('vendorbillmaster','vendorbillmaster.vendorBillMasterId = vendoradjustmentdetails.vendorBillMasterId','INNER')
	->join('rawmaterial_purchase_master','rawmaterial_purchase_master.id = vendorbillmaster.invoiceMasterId','INNER')
	->where($where);
				
		$query = $this->db->get();
		//echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}

	// Cheking For Service Purchase Payment 
	/*
	* @method : checkVendorPaymentAgainstBill
	* @date : 27.03.2018
	* By : Mithilesh
	* Table Considered : vendoradjustmentdetails,vendoradvanceadjustmentmaster,vendorbillmaster,voucher_master,rawmaterial_purchase_master
	*/
	public function checkVendorPaymentAgainstBill($purchase_id,$purchase_type)
	{
		$data = [];
		$where = array(
			"vendorbillmaster.invoiceMasterId" => $purchase_id,
			"vendorbillmaster.purchaseType" => $purchase_type,
			"rawmaterial_purchase_master.IsService" => 'Y'
		);

	$this->db->select('*')
	->from('vendorbillpaymentdetail')
	->join('vendorbillpaymentmaster','vendorbillpaymentmaster.vendorPaymentId = vendorbillpaymentdetail.vendorpaymentid','INNER')
	->join('voucher_master','voucher_master.id = vendorbillpaymentmaster.voucherId','INNER')
	->join('vendorbillmaster','vendorbillmaster.vendorBillMasterId = vendorbillpaymentdetail.vendorBillMaster','INNER')
	->join('rawmaterial_purchase_master','rawmaterial_purchase_master.id = vendorbillmaster.invoiceMasterId','INNER')
	->where($where);
				
		$query = $this->db->get();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}





}