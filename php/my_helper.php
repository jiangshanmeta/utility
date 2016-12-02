<?php
if(!function_exists('camelize')){
	function camelize($str){
		return strtolower($str[0]).substr(str_replace(' ', '', ucwords(preg_replace('/[\s_-]+/', ' ', $str))), 1);
	}
}

if(!function_exists('str_supplant')){
	function str_supplant($orginal_str,$replace_array){
		if(!is_array($replace_array)){
			return '';
		}
		$paramNames = [];
		$paramValues = [];
		foreach ($replace_array as $param_name => $param_value) {
			$paramNames[] = '{'.$param_name.'}';
			$paramValues[] = $param_value;
		}
		return str_replace($paramNames,$paramValues,$orginal_str);
	}
}

if(!function_exists('is_ajax_request')){
    function is_ajax_request() {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            return true;
        }
        return false;
    }	
}

if(!function_exists('get_client_ip')){
	function get_client_ip(){
		return $_SERVER['REMOTE_ADDR'];
	}
}
?>