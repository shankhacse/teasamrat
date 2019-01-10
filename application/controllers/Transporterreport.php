<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Transporterreport extends CI_Controller {

  public function __construct() {
        parent::__construct();
        $this->load->model('rawmaterialstockmodel', '', TRUE);
		$this->load->model('generalledgermodel', '', TRUE);
         
 }
        public function index()
        {
          $session = sessiondata_method();
			if ($this->session->userdata('logged_in')) {
				$year=$session['yearid'];
				$company=$session['company'];
             
			$fiscalStartDt = $this->generalledgermodel->getFiscalStartDt($year);
			$toDate = date('Y-m-d');
			
           // $result['rawmaterialStock'] =$this->rawmaterialstockmodel->getRawmaterialStockList($company,$year);
            $result['rawmaterialStock'] =$this->rawmaterialstockmodel->getRawmaterialStockList($fiscalStartDt,$toDate,$company,$year);
			/*
			echo "<pre>";
			print_r($result['rawmaterialStock']);
		    echo "</pre>";
		   */
            $this->db->freeDBResource($this->db->conn_id);
            $headercontent='';
            $page = 'rawmaterialstock/list';
            $header = '';
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
        }

        public function comments()
        {
                echo 'Look at this!';
        }
}