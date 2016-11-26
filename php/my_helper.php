<?php
if(!function_exists('camelize')){
	function camelize($str){
		return strtolower($str[0]).substr(str_replace(' ', '', ucwords(preg_replace('/[\s_-]+/', ' ', $str))), 1);
	}
}

?>