<?
require_once('Fields.php');
class Field_int extends Fields{
	function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
	}
	function gen_value($input){
		return (int)$input;
	}
}
?>