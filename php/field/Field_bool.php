<?
require_once('Field_enum.php');
class Field_bool extends Field_enum{
	public function __construct($show_name,$name,$is_must_input=FALSE){
		parent::__construct($show_name,$name,$is_must_input);
		$this->set_enum_key('bool');
		$this->set_enum([0=>'否',1=>'是']);
	}
	public function to_bool(){
		return $this->value === 1;
	}
}

?>