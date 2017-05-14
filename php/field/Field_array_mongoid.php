<?php
require_once('Field_array.php');
class Field_array_mongoid extends Field_array{
	public function __construct($show_name,$name,$is_must_input=FALSE){
		parent::__construct($show_name,$name,$is_must_input);
	}

	public function gen_value($input){
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