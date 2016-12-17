<?
require_once('Field_enum.php');
class Field_sex extends Field_enum{
	function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
		$this->setEnumPoolKey('sex');
		$this->setEnum([0=>'男',1=>'女']);
	}
}
?>