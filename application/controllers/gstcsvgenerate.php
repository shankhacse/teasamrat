<?php
//we need to call PHP's session object to access it through CI
class gstcsvgenerate extends CI_Controller {

     function __construct() {
        parent::__construct();
		
		$this->load->model('gstcsvgeneratemodel', '', TRUE);
		$this->load->model('companymodel', '', TRUE);
        
        
    }
    
    
      public function index() {
        
        $session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            
            $compny = $session['company'];
            $year = $session['yearid'];
			$result = "";
            $page = 'gst_csvgenerate/header_view';
            $header = '';
            $headercontent=NULL;
            createbody_method($result, $page, $header, $session, $headercontent);
        } else {
            redirect('login', 'refresh');
        }
    }
	
	public function generateCSV()
	{
		$session = sessiondata_method();
        if ($this->session->userdata('logged_in')) {
            
			$csvType = "";
            $fromDt = $this->input->post('fdate');
            $todate = $this->input->post('tdate');
			
			
			$fdate = date("Y-m-d",strtotime($fromDt));
			$tdate = date("Y-m-d",strtotime($todate));
			
			$compny = $session['company'];
            $year = $session['yearid'];
			$rowCompany = $this->companymodel->getCompanyByIdForCSV($compny);
			$state_code = $rowCompany->state_code;
			
			
			
			$csvType = $this->input->post('format'); 
			
			$result['csvGenerateData'] = $this->gstcsvgeneratemodel->getCSVData($csvType,$fdate,$tdate,$compny,$year,$state_code);
			$result['csvType'] = $csvType; 
			
			
			 $this->db->freeDBResource($this->db->conn_id); 
			
			  if($csvType=="B2B")
			  {
			  $page = 'gst_csvgenerate/csvgeneratelist';
			  }
			  if($csvType=="B2CL")
			  {
				$page = 'gst_csvgenerate/csvgeneratelist_b2cl'; 
			  }
			  if($csvType=="B2CS")
			  {
				$page = 'gst_csvgenerate/csvgeneratelist_b2cs'; 
			  }
			  $html = $this->load->view($page, $result);
			  echo $html;
			
            
        } else {
            redirect('login', 'refresh');
        }
	}
    
    
    



    
}

?>
