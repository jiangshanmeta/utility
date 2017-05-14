<?
require_once('Fields.php');
class Field_mongoid extends Fields{
	public function __construct($show_name,$name,$is_must_input=FALSE){
		parent::__construct($show_name,$name,$is_must_input);
		$this->typ = 'Field_mongoid';
	}
	public function gen_value($input){
		if(MongoId::isValid($input)){
			return (string)$input;
		}
		return NULL;
	}
	public function gen_show_value(){
		return (string)$this->value;
	}
}
?>