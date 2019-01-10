<?php


if(!function_exists('getEntryDate'))
{
	
	function getEntryDate(){
		$CI =& get_instance();
		$CI->load->library('session');
		$CI->load->model('financialyearmodel');
		$session = sessiondata_method();
		//print_r($session);
		$currdate = date("Y-m-d");
		
		$endDt = $session['endyear']."-03-31";
		
		$isCurrentYear = $CI->financialyearmodel->checkIsCurrentAccYear($endDt);
		
		$date = NULL;
		if($isCurrentYear){
			$date = date("d-m-Y");
		}
		else{
			$date = NULL;
		}
		
		return $date ;
	}
	
	
}


if(!function_exists('getReportDate'))
{
	function getReportDate(){
		$CI =& get_instance();
		$CI->load->library('session');
		$CI->load->model('financialyearmodel');
		$session = sessiondata_method();
		//print_r($session);
		$currdate = date("Y-m-d");
		
		$endDt = $session['endyear']."-03-31";
		
		$isCurrentYear = $CI->financialyearmodel->checkIsCurrentAccYear($endDt);
		
		$date = NULL;
		if($isCurrentYear){
			$date = date("d-m-Y");
		}
		else{
			$date = date("d-m-Y",strtotime($endDt));
		}
		
		return $date ;
	}
}


