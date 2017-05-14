<?php
require_once('Fields.php');
class Field_array extends Fields{
	function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
		$this->setDefault([]);
		$this->typ = 'Field_array';
	}
	function gen_value($value){
		if(is_string($value)){
			$value = json_decode($value,true);
		}
		if(!is_array($value)){
			$value = [];
		}
		return $value;
	}
	function gen_show_value(){
		return json_encode($this->value);
	}
}
?>