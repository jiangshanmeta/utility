<?
require_once('Field_enum.php');
class Field_sex extends Field_enum{
	public function __construct($show_name,$name,$is_must_input=FALSE){
		parent::__construct($show_name,$name,$is_must_input);
		$this->set_enum_key('sex');
		$this->set_enum([0=>'男',1=>'女']);
	}
}
?>