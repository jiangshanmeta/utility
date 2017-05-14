<?
require_once('Fields.php');
class Field_string extends Fields{
	public function __construct($show_name,$name,$is_must_input=FALSE){
		parent::__construct($show_name,$name,$is_must_input);
		$this->set_default('');
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
		$input_name = $this->build_input_name($typ);
		return "<input  type=\"text\"  class=\"$this->editor_class\" value=\"$value\" name=\"$input_name\" id=\"$input_name\"   >";
	}
}
?>