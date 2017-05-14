<?
require_once('Field_string.php');
class Field_pwd extends Field_string{
	public function __construct($show_name,$name,$is_must_input=FALSE){
		parent::__construct($show_name,$name,$is_must_input);
		$this->typ = 'Field_pwd';
	}
	public function gen_value($value){
		return strtolower(md5($value));
	}
	public function init($value){
		$this->value = (string)$value;
	}
	public function set_default($default){
		$this->default = (string)$default;
	}
	public function gen_editor($typ){
		$input_name = $this->build_input_name($typ);
		return "<input type=\"password\" class=\"$this->editor_class\"  name=\"$input_name\" id=\"$input_name\"   >";
	}


}
?>