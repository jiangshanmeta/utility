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
		$this->typ = 'Field_tag';
	}
	function setEnum($enum){
		if($this->_enum_pool_key){
			if(!isset(self::$_cache_enum[$this->_enum_pool_key]['enum'])){
				self::$_cache_enum[$this->_enum_pool_key]['enum'] = $enum;
				self::$_cache_enum[$this->_enum_pool_key]['keys'] = array_keys($enum);
			}
			$this->enum = &self::$_cache_enum[$this->_enum_pool_key]['enum'];
			$this->can_select = &self::$_cache_enum[$this->_enum_pool_key]['keys'];
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
		foreach ($input as $key => $value) {
			$input[$key] = (int)$value;
		}
		$input = array_values(array_intersect($this->can_select, $input));
		return $input;
	}

	function setFull(){
		$this->value = &$this->can_select;
	}

	function has($input){
		return in_array($input, $this->value);
	}


}
?>