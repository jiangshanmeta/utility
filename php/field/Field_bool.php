<?
require_once('Field_enum.php');
class Field_bool extends Field_enum{
	function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
		$this->setEnumPoolKey('bool');
		$this->setEnum([0=>'否',1=>'是']);
	}
	function toBool(){
		return $this->value === 1;
	}
}

?>