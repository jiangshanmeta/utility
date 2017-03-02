<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// 对ci load view的一个封装
class Template{
	protected $CI;
	public function __construct(){
		$this->templateData = [];
		$this->CI = &get_instance();
	}

	public function set($name,$value){
		$this->templateData[$name] = $value;
	}

	public function load($template,$view,$view_data = array(),$return = FALSE){
		$this->set('contents',$this->CI->load->view($view,$view_data,TRUE));
		return $this->CI->load->view($template,$this->templateData,$return);
	}
}
?>