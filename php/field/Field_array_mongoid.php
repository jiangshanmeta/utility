<?php
require_once('Field_array.php');
class Field_array_mongoid extends Field_array{
	function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
	}

	function gen_value($input){
		$input = parent::gen_value($input);
		$rst = [];
		foreach ($input as $value) {
			if(!MongoId::isValid($value)){
				continue;
			}
			$rst[] = (string)$value;
		}
		return $rst;
	}
}
?>