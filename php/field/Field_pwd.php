<?
require_once('Field_string.php');
class Field_pwd extends Field_string{
	function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
		$this->typ = 'Field_pwd';
	}
	function gen_value($value){
		return strtolower(md5($value));
	}
	function init($value){
		$this->value = (string)$value;
	}
	function setDefault($default){
		$this->default = (string)$default;
	}
}
?>