<?
require_once('Fields.php');
class Field_ts extends Fields{
	function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
		$this->typ = 'Field_ts';
	}
	function gen_value($input){
		if(is_string($input) && !is_numeric($input)){
			$input = strtotime($input);
		}
		return (int)$input;
	}
	function gen_show_value(){
		if($this->value<86400){
			return "-";
		}
		return date('Y-m-d H:i',$this->value);
	}
}
?>