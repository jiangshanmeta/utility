<?php
// 字符串 驼峰化
if(!function_exists('camelize')){
	function camelize($str){
		return strtolower($str[0]).substr(str_replace(' ', '', ucwords(preg_replace('/[\s_-]+/', ' ', $str))), 1);
	}
}

// 字符串 将驼峰化的字符串转换成连字符连接的
if(!function_exists('hyphenate')){
	function hyphenate($str){
		static $hyphenateRE = '/([^-])([A-Z])/';
		return strtolower(preg_replace($hyphenateRE, '$1-$2', preg_replace($hyphenateRE, '$1-$2', $str)));
	}
}

// 字符串 模板填充
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

// 之所以封装这个是因为经常用explode，但是原生explode返回的数组中会包含空字符串，一般是不需要的数据
if(!function_exists('explode_unempty')){
	function explode_unempty($delimiter,$string,$limit=NULL){
		$temp = explode($delimiter, $string);
		$rst = [];
		if(is_array($temp)&&count($temp)>0){
			foreach ($temp as $value) {
				if($value!==''){
					$rst[] = $value;
				}
			}
		}
		return array_slice($rst,0,$limit);
	}
}

// 因为常用的处理都是处理成array而不是stdClass，所以封装了这个方法
if(!function_exists('json_decode_array')){
	function json_decode_array($json,$depth = 512,$options = 0){
		$rst = json_decode($json,true,$depth,$options);
		if($rst===NULL){
			$rst = [];
		}
		return $rst;
	}
}

// 判断是否是json
if(!function_exists('is_json')){
	function is_json($json){
		if(!is_string($json)){
			return false;
		}
		return json_decode($json) !== NULL;
	}
}

// 判断是否是关联数组
if(!function_exists('is_assoc_array')){
	function is_assoc_array($array) {
		return is_array($array) && (count($array)===0 || count(array_diff_key($array, array_keys($array) ))!==0 );
	}
}

// addtoset 判断是否重复的push
if(!function_exists('array_addToSet')){
	function array_addToSet(&$array){
		$args = func_get_args();
		$length = func_num_args();
		for($i=1;$i<$length;$i++){
			if(!in_array($args[$i], $array)){
				$array[] = $args[$i];
			}
		}
	}
}

// 交换数组中两个元素
if(!function_exists("array_swap")){
	function array_swap(&$arr,$index1,$index2){
		if(!is_array($arr)){
			return false;
		}
		if($index1==$index2){
			return false;
		}
		$temp = $arr[$index1];
		$arr[$index1] = $arr[$index2];
		$arr[$index2] = $temp;
		return true;
	}
}

// 数组中每个元素执行一次$fn,当有一个元素使得$fn返回真值时返回true,其余返回false
if(!function_exists("array_some")){
	function array_some(array $arr,$fn){
		if(!is_callable($fn)){
			return false;
		}
		foreach ($arr as $key=>$value) {
			if($fn($value,$key)){
				return true;
			}
		}
		return false;
	}
}

// 数组中每一个元素执行$fn，若$fn均返回真值则返回true,否则返回false
if(!function_exists("array_every")){
	function array_every(array $arr,$fn){
		if(!is_callable($fn)){
			return false;
		}
		foreach ($arr as $key => $value) {
			if(!$fn($value,$key)){
				return false;
			}
		}
		return true;
	}
}

// 根据回调$fn找到数组中最大的值
if(!function_exists("array_max")){
	function array_max(array $arr,$fn=NULL){
		if(!is_callable($fn)){
			$fn = function($value){
				return $value;
			};
		}
		$result = -INF;
		$lastComputed = -INF;
		foreach ($arr as $key => $value) {
			$computed = $fn($value,$key);
			if($computed>$lastComputed || ($computed===-INF && $result=== -INF)){
				$lastComputed = $computed;
				$result = $value;
			}
		}
		return $result;
	}
}

// 根据回调$fn找到数组中最小的值
if(!function_exists("array_min")){
	function array_min(array $arr,$fn=NULL){
		if(!is_callable($fn)){
			$fn = function($value){
				return $value;
			};
		}
		$result = INF;
		$lastComputed = INF;
		foreach ($arr as $key => $value) {
			$computed = $fn($value,$key);
			if($computed<$lastComputed || ($computed===INF && $result===INF)){
				$lastComputed = $computed;
				$result = $value;
			}
		}
		return $result;
	}
}

// 求得数组中元素的平均值，支持回调
if(!function_exists("array_avg")){
	function array_avg(array &$arr,$fn=NULL){
		if(!is_callable($fn)){
			return array_sum($arr)/count($arr);
		}
		$sum = 0;
		foreach ($arr as $key => $value) {
			$sum += $fn($value,$key);
		}
		return $sum/count($arr);
	}
}

// 获取文件扩展名
if(!function_exists('get_extension')){
	function get_extension($filename){
		return pathinfo($filename,PATHINFO_EXTENSION);
	}
}

// 获取文件名
if(!function_exists('get_filename')){
	function get_filename($filename){
		return pathinfo($filename,PATHINFO_FILENAME);
	}
}

// 判断是否是偶数
if(!function_exists('is_even')){
	function is_even($num){
		if(!is_int($num)){
			return false;
		}
		return !($num%2);
	}
}

// 判断是否是奇数
if(!function_exists('is_odd')){
	function is_odd($num){
		if(!is_int($num)){
			return false;
		}
		return (bool)($num%2);
	}
}



?>