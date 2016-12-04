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

if(!function_exists('curl_post')){
	function curl_post($url,$data){
		// 对于$data不应该做处理，因为data的格式是要和被请求端约定的，因此这里传入的应该是最终格式
		
		$ch = curl_init();// 初始化curl

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// 设置执行后不直接打印出来
		curl_setopt($ch, CURLOPT_URL, $url);// 设置请求地址
		curl_setopt($ch, CURLOPT_POST, true);// post方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);// post的数据
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//终止服务器端验证

		$rst = curl_exec($ch);// 执行curl请求
		
		curl_close($ch);// 释放句柄
		return $rst;
	}
}

if(!function_exists('curl_get')){
	function curl_get($url){
		$ch = curl_init();// 初始化curl
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);// 设置执行后不直接打印出来
		curl_setopt($ch, CURLOPT_URL, $url);// 设置请求地址
		curl_setopt($ch, CURLOPT_HEADER, 0);//不返回头信息
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);//终止服务器端验证

		$rst = curl_exec($ch);// 执行curl请求
		
		curl_close($ch);// 释放句柄
		return $rst;
	}
}
?>