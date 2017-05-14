<?php
require_once('Fields.php');
class Field_array extends Fields{
	public function __construct($show_name,$name,$is_must_input=FALSE){
		parent::__construct($show_name,$name,$is_must_input);
		$this->set_default([]);
		$this->typ = 'Field_array';
	}
	public function gen_value($value){
		if(is_string($value)){
			$value = json_decode($value,true);
		}
		if(!is_array($value)){
			$value = [];
		}
		return $value;
	}
	public function gen_show_value(){
		return json_encode($this->value);
	}
}
?>