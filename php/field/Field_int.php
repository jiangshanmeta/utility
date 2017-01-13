<?
require_once('Fields.php');
class Field_int extends Fields{
	function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
		$this->typ = 'Field_int';
	}
	function gen_value($input){
		return (int)$input;
	}
	public function gen_editor($typ){
		$value = "";
		switch ($typ) {
			case 0:
				$value = "";
				break;
			case 1:
				$value = $this->value;
				break;
			default:
				$value = "";
				break;
		}
		$inputName = $this->build_input_name($typ);
		return "<input type=\"text\"  class=\"$this->editorClass\" value=\"$value\" name=\"$inputName\" id=\"$inputName\"   >";
	}


}
?>