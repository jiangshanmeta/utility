<?
require_once('Fields.php');
class Field_float extends Fields{
	public function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
		$this->setDefault(0);
	}
	public function init($value){
		parent::init((float)$value);
	}
	public function gen_value($input){
		return (float)$input;
	}
	public function setDefault($value){
		parent::setDefault((float)$value);
	}

}
?>