<?
require_once('Fields.php');
class Field_string extends Fields{
	public function __construct($showName,$name,$isMustInput=FALSE){
		parent::__construct($showName,$name,$isMustInput);
		$this->setDefault('');
		$this->typ = 'Field_string';
	}
	public function gen_value($input){
		return (string)$input;
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
		return "<input  type=\"text\"  class=\"$this->editorClass\" value=\"$value\" name=\"$inputName\" id=\"$inputName\"   >";
	}
}
?>