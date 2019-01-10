<?php


if(!function_exists('getUserIPAddress'))
{
	
	function getUserIPAddress(){
		$CI =& get_instance();
		$ip_add="";
		$ip_add = $CI->input->ip_address();
		return $ip_add ;
	}
}

if(!function_exists('getUserBrowserName'))
{
	function getUserBrowserName(){
		
		$CI =& get_instance();
		$CI->load->library('user_agent');
		$agent = "";
		if ($CI->agent->is_browser())
		{
				$agent = $CI->agent->browser();
		}
		elseif ($CI->agent->is_robot())
		{
				$agent = $CI->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
				$agent = $CI->agent->mobile();
		}
		else
		{
				$agent = 'Unidentified';
		}
		return $agent ;
	}
}
if(!function_exists('getUserPlatform'))
{
	function getUserPlatform()
	{
		$CI =& get_instance();
		$user_platform = "";
		$user_platform = $CI->agent->platform();
		return $user_platform ;
	}
}

