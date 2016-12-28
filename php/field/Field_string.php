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
}
?>