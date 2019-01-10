<?php


if(!function_exists('pre'))
{
	
	function pre($printarry){
		$CI =& get_instance();
		echo "<pre>";
		print_r($printarry);
		echo "</pre>";
	}
}
