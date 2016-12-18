<?
require_once('Fields.php');
class Field_mongoid extends Fields{
	function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
	}
	function gen_value($input){
		if(MongoId::isValid($input)){
			if(is_string($input)){
				$input = new MongoId($input);
			}
			return $input;
		}
		return NULL;
	}
	function gen_show_value(){
		return (string)$this->value;
	}
}
?>