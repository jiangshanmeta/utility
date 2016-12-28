<?
require_once('Fields.php');
class Field_mongoid extends Fields{
	function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
		$this->typ = 'Field_mongoid';
	}
	function gen_value($input){
		if(MongoId::isValid($input)){
			return (string)$input;
		}
		return NULL;
	}
	function gen_show_value(){
		return (string)$this->value;
	}
}
?>