<?
require_once('Fields.php');
class Field_int extends Fields{
	function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
	}
	function gen_value($input){
		return (int)$input;
	}
	function init($value){
		parent::init((int)$value);
	}
	function setDefault($value){
		parent::setDefault((int)$value);
	}
}
?>