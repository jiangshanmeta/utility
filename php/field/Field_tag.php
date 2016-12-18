<?
require_once('Field_array.php');
class Field_tag extends Field_array{
	protected  $_enum_pool_key;
	public $enum;
	public $can_select = [];
	function __construct($showName,$name,$isMustInput=FALSE,$tableName=''){
		parent::__construct($showName,$name,$isMustInput);
		if($tableName!=''){
			$this->setEnumPoolKey($tableName.'_'.$name);
		}
	}
	function setEnum($enum){
		if($this->_enum_pool_key){
			if(!isset(self::$_enum_pool[$this->_enum_pool_key]['enum'])){
				self::$_enum_pool[$this->_enum_pool_key]['enum'] = $enum;
				self::$_enum_pool[$this->_enum_pool_key]['keys'] = array_keys($enum);
			}
			$this->enum = &self::$_enum_pool[$this->_enum_pool_key]['enum'];
			$this->can_select = &self::$_enum_pool[$this->_enum_pool_key]['keys'];
		}else{
			$this->enum = $enum;
			$this->can_select = array_keys($enum);
		}
	}
	public function setEnumPoolKey($key){
		$this->_enum_pool_key = $key;
	}

	function gen_value($input){
		$input = parent::gen_value($input);
		$input = array_values(array_intersect($this->can_select, $input));
		return $input;
	}


}
?>