<?
require_once('Fields.php');
class Field_string extends Fields{
	public function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
		$this->setDefault('');
	}
	public function init($value){
		parent::init((string)$value);
	}
	public function gen_value($input){
		return (string)$input;
	}
	public function setDefault($value){
		parent::setDefault((string)$value);
	}
}
?>