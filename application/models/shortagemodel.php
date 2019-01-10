<?php

class shortagemodel extends CI_Model {

    /**
     * @mehod getDoLists
     * @param type $purchaseInvoiceID
     * @return boolean
     * @description List of 'do' received
     */
    public function getBagDetails($purchaseMasterId, $transporterId) {

        $data =array();

        $sql = "SELECT purchase_invoice_master.`id` AS pMstId,purchase_invoice_detail.`id` AS pDtlId,purchase_bag_details.`id` AS pBagDtlId,
                    `purchase_invoice_detail`.`do` as DeliveryOrderNo, purchase_invoice_detail.`invoice_number`,
                    purchase_bag_details.`bagtypeid`,bagtypemaster.`bagtype`,purchase_bag_details.`no_of_bags`,
                    purchase_bag_details.`net`,purchase_bag_details.`actual_bags`,purchase_bag_details.`parent_bag_id`,purchase_bag_details.shortkg,
                    purchase_bag_details.`challanno`,
                    DATE_FORMAT(`purchase_bag_details`.`challandate`,'%d-%m-%Y') AS chalandate 
                    FROM
                    `purchase_invoice_master` INNER JOIN `purchase_invoice_detail` ON
                    `purchase_invoice_master`.`id`=`purchase_invoice_detail`.`purchase_master_id` 
                    INNER JOIN `purchase_bag_details` ON `purchase_invoice_detail`.`id`=`purchase_bag_details`.`purchasedtlid`
                    INNER JOIN `do_to_transporter` ON `do_to_transporter`.`purchase_inv_dtlid` = `purchase_invoice_detail`.`id`
                    INNER JOIN bagtypemaster ON bagtypemaster.`id` =`purchase_bag_details`.`bagtypeid`
                    WHERE `purchase_invoice_master`.id='" . $purchaseMasterId . "' AND `do_to_transporter`.`transporterId`='" . $transporterId . "' AND 
                        `do_to_transporter`.`in_Stock` ='Y'  ORDER BY `purchase_invoice_detail`.`id`";

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
								"pMstId"=>$rows->pMstId,
								"pDtlId"=>$rows->pDtlId,
								"pBagDtlId"=>$rows->pBagDtlId,
								"DeliveryOrderNo"=>$rows->DeliveryOrderNo,
								"invoice_number"=>$rows->invoice_number,
								"bagtypeid"=>$rows->bagtypeid,
								"bagtype"=>$rows->bagtype,
								"no_of_bags"=>$rows->no_of_bags,
								"net"=>$rows->net,
								"actual_bags"=>$rows->actual_bags,
								"parent_bag_id"=>$rows->parent_bag_id,
								"shortkg"=>$rows->shortkg,
								"challanno"=>$rows->challanno,
								"chalandate"=>$rows->chalandate,
								"Returnable"=>$this->getSummationOfActualBags($rows->pBagDtlId,$rows->no_of_bags,$rows->actual_bags)
								
								
				);
            }




            return $data;
        } else {
            return $data;
        }
    }

	private function getSummationOfActualBags($baddtlId,$noBags,$actualBagofCurrentRow){
	
	
	$sumOfactualBag =0;
	if($noBags!=$actualBagofCurrentRow){
	$sql="SELECT SUM(purchase_bag_details.`actual_bags`) AS actualTotal
			FROM purchase_bag_details WHERE purchase_bag_details.`parent_bag_id`=".$baddtlId." AND purchase_bag_details.net<>0  ";
	
		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			$sumOfactualBag = $query->row()->actualTotal + $actualBagofCurrentRow; 
		}
		if($noBags==$sumOfactualBag){
			return 	0;
		}
		else{
			return 1;
			}
	
	}else{
		return 0;
	}
	
	
	
	
	
	
	}
	
    public function getPurchaseInvoice($company) {
       
       /* $sql="SELECT `purchase_invoice_master`.`purchase_invoice_number`,purchase_invoice_master.`id` FROM purchase_invoice_master WHERE
              purchase_invoice_master.`id`
              IN(SELECT DISTINCT do_to_transporter.`purchase_inv_mst_id` FROM do_to_transporter WHERE `do_to_transporter`.`is_sent`='Y')";*/
        
        $sql="SELECT `purchase_invoice_master`.`purchase_invoice_number`,purchase_invoice_master.`id` FROM purchase_invoice_master WHERE
              purchase_invoice_master.`id`
              IN(SELECT DISTINCT do_to_transporter.`purchase_inv_mst_id` FROM do_to_transporter WHERE `do_to_transporter`.`is_sent`='Y')
              AND purchase_invoice_master.`from_where`<>'OP' AND purchase_invoice_master.`from_where`<>'STI' AND purchase_invoice_master.company_id=".$company." ORDER BY `purchase_invoice_master`.`purchase_invoice_number`";
        
        
        
        
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = $rows;
            }

            return $data;
        } else {
            return false;
        }
    }
    
    public function getParentActualBag($id){
        
        $this->db->select('actual_bags');
        $this->db->from('purchase_bag_details');
        $this->db->where('id',$id);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
            return $row->actual_bags;
        }

        return null;
    }
    
     public function getParentBagNet($id){
        
        $this->db->select('net');
        $this->db->from('purchase_bag_details');
        $this->db->where('id',$id);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
            return $row->net;
        }

        return null;
    }
    
	
	 public function getParentBagNetandNoBags($id){
        
       
		$sql="SELECT `shortkg` AS net,SUM(`actual_bags`) AS noBags
				FROM (`purchase_bag_details`)
				GROUP BY purchase_bag_details.`parent_bag_id`,purchase_bag_details.`bagtypeid`,purchase_bag_details.`net`
				HAVING purchase_bag_details.`parent_bag_id` =  '".$id."' AND purchase_bag_details.`bagtypeid` =3 AND purchase_bag_details.`net` = 0";
		
		
        $query = $this->db->query($sql);
		//echo $this->db->last_query();
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
			$data =array(
							"net"=>$row->net,
							"noBags"=>$row->noBags
			);
            return $data;
        }

        return null;
    }
    public function getPdtlIdByParent($parentId){
			$sql="SELECT purchase_bag_details.`purchasedtlid` FROM purchase_bag_details WHERE purchase_bag_details.`id`=".$parentId;
			$query = $this->db->query($sql);
		//echo $this->db->last_query();
        if ($query->num_rows() > 0)
        {
            $row = $query->row(); 
			$data = $row->purchasedtlid;
            return $data;
        }

        return null;
	
	}
	
	public function SaveReturnBag($data){
	try {
            $this->db->trans_begin();

            $this->db->insert('purchase_bag_details', $data);
            $insertid = $this->db->insert_id();



            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
	
	}
    
    

    public function InsertShortage($PurchaseBagDetailIds, $Shortdata, $parentbagdata) {



        try {
            $this->db->trans_begin();

            $this->db->where('id', $PurchaseBagDetailIds);
            $this->db->update('purchase_bag_details', $parentbagdata);



            $this->db->insert('purchase_bag_details', $Shortdata);
            $insertid = $this->db->insert_id();



            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
    }

    
    
    public function update($PurchaseBagDetailIds,$Shortdata,$parentbagdata,$parentId){
        
         try {
            $this->db->trans_begin();

            $this->db->where('id', $parentId);
            $this->db->update('purchase_bag_details', $parentbagdata);



            $this->db->where('id', $PurchaseBagDetailIds);
            $this->db->update('purchase_bag_details', $Shortdata);



            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
    }
    
    public function deleteShortBag($purchaseBagDetailId,$parentBagId,$dataOfPbag){
        
        try {
            $this->db->trans_begin();

            $this->db->where('id', $parentBagId);
            $this->db->update('purchase_bag_details', $dataOfPbag);
            $this->db->where('id', $purchaseBagDetailId);
            $this->db->delete('purchase_bag_details');
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
        
    }
	public function deleteReturnBag($purchaseBagDetailId){
	  try {
            $this->db->trans_begin();
            $this->db->where('id', $purchaseBagDetailId);
            $this->db->delete('purchase_bag_details');
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        } catch (Exception $e) {
            echo ($e->getMessage());
        }
	
	}

     public function getFiscalStartDt($yearid){
        $sql="SELECT * FROM financialyear WHERE financialyear.id=".$yearid;
        $query = $this->db->query($sql);
         if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    return $rows;
                }
         }
        
    }
 

    public function shortageRegByDate($fdate,$tdate,$invoice,$drpTransporter){
       
       
        if($invoice!='0' && $drpTransporter!='0'){
             $where_con = array(
            "purchase_invoice_master.id"=>$invoice,
            "do_to_transporter.transporterId"=>$drpTransporter, 
            "do_to_transporter.in_Stock"=>'Y', 
            "bagtypemaster.bagtype"=>'Shortage' 
        );
        }else if($invoice=='0' && $drpTransporter=='0'){
             $where_con = array( 
            "do_to_transporter.in_Stock"=>'Y', 
            "bagtypemaster.bagtype"=>'Shortage' 
        );
        }else if($invoice=='0'){
              $where_con = array(
            "do_to_transporter.transporterId"=>$drpTransporter, 
            "do_to_transporter.in_Stock"=>'Y', 
            "bagtypemaster.bagtype"=>'Shortage' 
        ); 
        }else if($drpTransporter=='0'){
             $where_con = array(
            "purchase_invoice_master.id"=>$invoice, 
            "do_to_transporter.in_Stock"=>'Y', 
            "bagtypemaster.bagtype"=>'Shortage' 
        ); 
        }


           $this->db->select("
                              `transport`.`id`, 
                              `transport`.`name`,
                              purchase_invoice_master.`purchase_invoice_number`,
                              purchase_invoice_master.`id` AS pMstId,
                              purchase_invoice_master.`purchase_invoice_date`,
                              purchase_invoice_detail.`id` AS pDtlId,
                              purchase_bag_details.`id` AS pBagDtlId,
                              `purchase_invoice_detail`.`do` AS DeliveryOrderNo,
                              purchase_invoice_detail.`invoice_number`,
                              purchase_bag_details.`bagtypeid`,
                              bagtypemaster.`bagtype`,
                              purchase_bag_details.`no_of_bags`,
                              purchase_bag_details.`net`,
                              purchase_bag_details.`actual_bags`,
                              purchase_bag_details.`parent_bag_id`,
                              purchase_bag_details.shortkg,
                              purchase_bag_details.`challanno`
                              ")
                         ->from('purchase_invoice_master')
                         ->join('purchase_invoice_detail','purchase_invoice_detail.purchase_master_id=purchase_invoice_master.id','INNER')
                         ->join('purchase_bag_details','purchase_bag_details.purchasedtlid=purchase_invoice_detail.id','INNER')
                         ->join('do_to_transporter','do_to_transporter.purchase_inv_dtlid=purchase_invoice_detail.id','INNER')
                         ->join('bagtypemaster','bagtypemaster.id=purchase_bag_details.bagtypeid','INNER')
                         ->join('transport','transport.id=do_to_transporter.transporterId','INNER')
                         ->where("purchase_invoice_master.purchase_invoice_date BETWEEN '".$fdate."' AND '".$tdate."' ")
                         ->where($where_con)
                         ->order_by('transport.id');

          $query = $this->db->get();   
          #echo $this->db->last_query();   
                   
          if ($query->num_rows() > 0) {
           foreach ($query->result() as $rows)
            {   //$data[]=$rows;
                 $data[] = array(
                    "transportid" => $rows->id,
                    "transportername" => $rows->name,
                    "purchase_invoice_number" => $rows->purchase_invoice_number,
                    "pMstId" => $rows->pMstId,
                    "purchase_invoice_date" => $rows->purchase_invoice_date,
                    "pDtlId" => $rows->pDtlId,
                    "pBagDtlId" => $rows->pBagDtlId,
                    "DeliveryOrderNo" => $rows->DeliveryOrderNo,
                    "invoice_number" => $rows->invoice_number,
                    "bagtypeid" => $rows->bagtypeid,
                    "bagtype" => $rows->bagtype,
                    "no_of_bags" => $rows->no_of_bags,
                    "net" => $rows->net,
                    "actual_bags" => $rows->actual_bags,
                    "parent_bag_id" => $rows->parent_bag_id,
                    "shortkg" => $rows->shortkg,
                    "challanno" => $rows->challanno,
                    "parent_no_of_bags" => $this->getParentBagNodtl($rows->parent_bag_id),
                    "parent_net" => $this->getParentBagNetdtl($rows->parent_bag_id),
                    "grade"=>$this->getParentgrade($rows->pDtlId),
                    "return_row"=>$this->getRerurnDtl($rows->parent_bag_id) // it have to check parent perches bag detail id working on process.....
                 
                ); 
               
            }
            
            return $data;
        }
        else{
            return $data;
        }
        
    }


public function getParentBagNodtl($parent_bag_id){
        $where_con = array(
            "purchase_bag_details.id"=>$parent_bag_id,
           
        );
        
        $this->db->select("purchase_bag_details.`no_of_bags`")
                         ->from('purchase_bag_details')
                         ->where($where_con);
          $query = $this->db->get();   
         # echo $this->db->last_query(); 
       
       
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $result = $row->no_of_bags;
            return $result;
        } else {
            return 0;
        }
        
    }


public function getParentBagNetdtl($parent_bag_id){
        $where_con = array(
            "purchase_bag_details.id"=>$parent_bag_id,
            
        );
        
        $this->db->select("purchase_bag_details.`net`")
                         ->from('purchase_bag_details')
                         ->where($where_con);
          $query = $this->db->get();   
         # echo $this->db->last_query(); 
       
       
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $result = $row->net;
            return $result;
        } else {
            return 0;
        }
        
    }

public function getParentgrade($invoice_dtl_id){
        $grade="";
        $where_con = array(
            "purchase_invoice_detail.id"=>$invoice_dtl_id
            
        );
        
        $this->db->select("grade_master.`grade`")
                         ->from('grade_master')
                          ->join('purchase_invoice_detail','purchase_invoice_detail.grade_id=grade_master.id','INNER')
                         ->where($where_con);
          $query = $this->db->get();   
          #echo $this->db->last_query(); 
       
       
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $result = $row->grade;
            return $result;
        } else {
            return $grade;
        }
        
    }


public function getRerurnDtl($parent_bag_id){
        $grade="";
        $where_con = array(
            "purchase_bag_details.parent_bag_id"=>$parent_bag_id,
            "purchase_bag_details.bagtypeid"=>4 
        );
        
        $this->db->select("*")
                         ->from('purchase_bag_details')
                         ->where($where_con);
          $query = $this->db->get();   
          #echo $this->db->last_query(); 
       
       
        if ($query->num_rows() > 0) {
            $row = $query->row();

            return $row;
        } else {
            return 0;
        }
        
    }

    
}//end of class
