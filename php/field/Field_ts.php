<?
require_once('Fields.php');
class Field_ts extends Fields{
	public function __construct($show_name,$name,$is_must_input=FALSE){
		parent::__construct($show_name,$name,$is_must_input);
		$this->typ = 'Field_ts';
	}
	public function gen_value($input){
		if(is_string($input) && !is_numeric($input)){
			$input = strtotime($input);
		}
		return (int)$input;
	}
	public function gen_show_value(){
		if($this->value<86400){
			return "-";
		}
		return date('Y-m-d H:i',$this->value);
	}
}
?>